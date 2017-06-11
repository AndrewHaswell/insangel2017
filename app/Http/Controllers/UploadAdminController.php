<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Venue;
use App\Band;
use App\Gig;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Monolog\Logger;

use Illuminate\Http\Request;

class UploadAdminController extends Controller
{
  public function __construct()
  {

  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    return view('admin.gig.upload');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    echo '<pre>';
    $gig_data = Input::all();

    $cover_gig = 'N';
    if ($gig_data['double']) {
      $temp_notes = explode("\n", $gig_data['notes']);
      $new_gig_data = [];
      foreach ($temp_notes as $key => $line) {
        if ($key % 2 == 0) {
          $new_gig_data[] = $line;
        }
      }
      $gig_data['notes'] = implode("\n", $new_gig_data);
    }

    $gig_data = explode("\n\r", $gig_data['notes']);

    foreach ($gig_data as $gig) {

      echo 'Adding gig...' . "\n\r";
      echo trim($gig) . "\n\r";

      $this_cover_gig = $cover_gig;

      $gig_details = explode("\n", trim($gig));
      if (count($gig_details) < 3) {
        echo 'Not enough data to be a gig... skipping' . "\n\r\n\r" . '-------------------------' . "\n\r\n\r";

        continue;
      } else {
        $gig_details = array_filter(array_map('trim', $gig_details));
      }
      $facebook_link = '';
      $last_line = array_pop($gig_details);

      if (!filter_var($last_line, FILTER_VALIDATE_URL) === false) {
        echo "Adding Facebook link..." . "\n\r";
        $facebook_link = $last_line;
        $last_line = array_pop($gig_details);
      }
      $gig_extra_details = array_map('trim', explode('/', $last_line));

      array_pop($gig_extra_details);// Dump the phone number

      $gig_time = $this->fix_time(array_pop($gig_extra_details));
      $gig_cost = array_pop($gig_extra_details);

      $gig_cost = preg_match('/[0-9]/i', $gig_cost)
        ? '&pound;' . number_format(preg_replace('/[^0-9\.]/i', '', $gig_cost), 2) : 'FREE';
      $gig_venue = array_filter(array_map('trim', explode(',', array_pop($gig_details))));

      $venue_name = array_shift($gig_venue);
      $venue_address = implode(', ', $gig_venue);

      $gig_date = Carbon::createFromFormat('l jS F H:i:s', array_shift($gig_details) . ' ' . $gig_time);
      $gig_title = array_shift($gig_details);

      $bands = array_reverse($gig_details, true);

      if (empty($bands)) {
        $bands = [$gig_title];
        $gig_title = '';
        $this_cover_gig = 'Y';
        echo "Sending as a cover gig" . "\n\r";
      }

      $this_line = true;
      $next_line = false;

      $all_bands = [];
      $all_bands_keys = [];

      foreach ($bands as $key => $band) {

        $these_bands = array_map('trim', explode('+', $band));

        $first_band = current($these_bands);
        $last_band = end($these_bands);

        if ($this_line || empty($last_band) || $next_line) {
          $this_line = true;
        }
        if (empty($first_band)) {
          $next_line = true;
        }

        if ($this_line) {
          $all_bands[] = $these_bands;
          $all_bands_keys[] = $key;
        }
        $this_line = false;
      }

      unset($bands);

      foreach ($all_bands_keys as $key) {
        unset($gig_details[$key]);
      }

      $all_bands = array_reverse($all_bands);
      $band_list = [];

      foreach ($all_bands as $all_band) {
        $band_list = array_merge($band_list, $all_band);
      }

      $band_list = array_filter($band_list);

      $gig_subtitle = !empty($gig_details) ? implode(' ', $gig_details) : '';

      $venue = Venue::firstOrCreate(['venue_name' => $venue_name]);

      if (empty($venue->venue_address)) {
        $venue->venue_address = $venue_address;
        $venue->save();
      }

      echo 'Adding venue...' . "\n";
      echo 'Venue Name: ' . $venue_name . "\n";
      echo 'Venue Address: ' . $venue_address . "\n\r";

      $gig = Gig::firstOrCreate(['venue_id' => $venue->id,
                                 'datetime' => $gig_date,]);

      // Update the rest of the gig info
      $gig->title = $gig_title;
      echo 'Gig Title: ' . $gig_title . "\n";

      $gig->subtitle = $gig_subtitle;
      echo 'Gig Subtitle: ' . $gig_subtitle . "\n";
      $gig->cost = $gig_cost;
      echo 'Gig Cost: ' . $gig_cost . "\n";
      $gig->notes = $facebook_link;

      echo 'Event Link: ' . $facebook_link . "\n\r";
      $gig->cover = $this_cover_gig;
      $gig->save();

      $gig->bands()->detach();

      echo 'Adding bands...' . "\n\r";

      foreach ($band_list as $band) {
        $this_band = Band::firstOrCreate(['band_name' => ($band ?: 'TBC')]);
        echo $band . "\n";
        // Assign the band to the gig
        $gig->bands()->save($this_band);
      }
      echo "\r" . 'Gig saved' . "\n\r\n\r" . '-------------------------' . "\n\r\n\r";
    }
    exit('Done');
  }

  /**
   *
   *
   * @param $time
   *
   * @return string
   *
   * @author Andrew Haswell
   */

  private function fix_time($time)
  {
    $pm = strpos($time, 'pm') !== false ? true : false;
    $time = str_pad(preg_replace('/[^0-9]*/i', '', $time), 5, '0', STR_PAD_RIGHT);
    $time = $pm ? $time + 120000 : str_pad($time, 6, '0', STR_PAD_LEFT);
    return implode(':', str_split($time, 2));
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   *
   * @return Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   *
   * @return Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int $id
   *
   * @return Response
   */
  public function update($id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   *
   * @return Response
   */
  public function destroy($id)
  {
    //
  }
}
