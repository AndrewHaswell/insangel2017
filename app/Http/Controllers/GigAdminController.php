<?php namespace App\Http\Controllers;

use App\Gig;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Band;
use App\Http\Requests\storeGigAdminRequest;
use App\Venue;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Request;

class GigAdminController extends Controller
{

  public function __construct()
  {
    $authorised = Auth::check();
    if (!$authorised) {
      abort(403, 'Unauthorized action.');
    }
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $gigs = Gig::AllByDate()->get();
    $delete = true;
    return view('admin.gig.show', compact('gigs', 'delete'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */

  public function create()
  {
    $venues = Venue::all(['id',
                          'venue_name'])->keyBy('venue_name')->toArray();
    array_walk($venues, function (&$value) {
      $value = $value['venue_name'];
    });

    return view('admin.gig.create', compact('venues'));
  }

  public function upload_gig()
  {
    return view('admin.band.upload');
  }

  public function upload(uploadGigAdminRequest $request)
  {
    // Get the form data
    $gig_data = Input::all();
    var_dump($gig_data);
    exit();
  }

  /**
   * Save the results of the gig form
   *
   * @param storeGigAdminRequest $request
   *
   * @return static
   * @author Andrew Haswell
   */

  public function store(storeGigAdminRequest $request)
  {
    // Get the form data
    $gig_data = Input::all();

    // Get or create the venue for the gig
    $venue = Venue::firstOrCreate(['venue_name' => $gig_data['venue'],
                                   'seo_name'   => insangel_case($gig_data['venue'])]);

    if (!empty($gig_data['gig_id'])) {
      $gig = Gig::findOrFail($gig_data['gig_id']);
      $gig->venue_id = $venue->id;
      $gig->datetime = $gig_data['date'];
      $message = 'Gig updated';
    }

    if (!isset($gig)) {
      // Get or create the gig based on the venue and the time
      $gig = Gig::firstOrCreate(['venue_id' => $venue->id,
                                 'datetime' => $gig_data['date'],]);

      //dd($gig);
      $message = 'Gig created';
    }

    // Update the rest of the gig info
    $gig->title = $gig_data['title'];
    $gig->subtitle = $gig_data['subtitle'];
    $gig->cost = $gig_data['cost'];
    $gig->notes = $gig_data['notes'];
    $gig->links = $gig_data['links'];
    $gig->cover = (!empty($gig_data['cover'])
      ? 'Y'
      : 'N');

    $gig->save();

    //dd($gig);

    // Remove any attached bands from the gig
    $gig->bands()->detach();

    // Update the band info
    foreach ($gig_data['bands'] as $band) {

      $band_name = $band
        ?: 'TBC';

      // Get or create the band
      $this_band = Band::firstOrCreate(['band_name' => $band_name,
                                        'seo_name'  => insangel_case($band_name)]);
      // Assign the band to the gig
      $gig->bands()->save($this_band);
    }

    return Redirect::action('GigAdminController@index')->with('message', $message);
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
    $venues = Venue::all(['id',
                          'venue_name'])->keyBy('venue_name')->toArray();
    array_walk($venues, function (&$value) {
      $value = $value['venue_name'];
    });
    $gigs = Gig::AllByDate()->findOrfail($id);
    $submit = $title = 'Edit Gig';

    return view('admin.gig.create', compact('venues', 'gigs', 'submit', 'title'));
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
    $gig = Gig::find($id);
    $message = 'Gig deleted';
    $gig->delete();

    return Redirect::action('GigAdminController@index')->with('message', $message);
  }

}
