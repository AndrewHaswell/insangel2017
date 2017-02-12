<?php namespace App\Http\Controllers;

use App\Gig;
use App\Band;
use App\Sponsor;
use App\Venue;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GigController extends Controller
{

  public function index()
  {
    $gigs = Gig::AllCurrentByDate()->get();
    $cover_gigs = Venue::AllCoverVenues()->get();
    $sponsors = Sponsor::all();

    // return $cover_gigs;

    return view('gig.show', compact('gigs', 'cover_gigs', 'sponsors'));
  }

  public function gig_list()
  {

    $gig_download = [];

    $gigs = Gig::AllCurrentByDate()->get();

    if (!empty($gigs)) {
      foreach ($gigs as $gig) {
        $this_gig = [];
        $this_gig[] = date('l jS F', strtotime($gig['datetime']));

        if (!empty($gig['title'])) {
          $this_gig[] = $gig['title'];
        }

        if (!empty($gig['subtitle'])) {
          $this_gig[] = $gig['subtitle'];
        }

        $band_list = array_chunk($gig->bands->pluck('band_name')->toArray(), 3);

        $first_row = true;

        foreach ($band_list as $bands) {
          $this_gig[] = ($first_row
              ? ''
              : '+ ') . implode(' + ', $bands);
          $first_row = false;
        }

        $venue = $gig->venue['venue_name'];

        if (!empty($gig->venue['venue_address'])) {
          $venue .= ', ' . $gig->venue['venue_address'];
        }

        if (!empty($gig['notes'])) {
          $this_gig[] = $gig['notes'];
        }

        $this_gig[] = trim($venue);

        $details = [];

        $details[] = is_numeric($gig['cost'])
          ? '£' . number_format($gig['cost'], 2)
          : $gig['cost'];
        $details[] = date('g.ia', strtotime($gig['datetime']));
        $details[] = '07901 616 185'; //TODO Un-hardcode this

        $this_gig[] = implode(' | ', $details);

        $gig_download[] = implode("\n\r\n\r", $this_gig);
      }
    }

    $cover_gigs = Venue::AllCoverVenues()->get();

    if (count($cover_gigs) > 0) {
      $gig_download[] = str_pad('-', 40, '-') . "\n\r\n\r" . 'COVER GIGS AND VENUES' . "\n\r\n\r" . str_pad('-', 40, '-');

      foreach ($cover_gigs as $cover_gig) {
        if (count($cover_gig->gigs) > 0) {
          $this_cover_gig = [];

          $venue = $cover_gig['venue_name'];

          if (!empty($cover_gig['venue_address'])) {
            $venue .= ', ' . $cover_gig['venue_address'];
          }

          $this_cover_gig[] = $venue;

          foreach ($cover_gig->gigs as $gig) {
            $bands = implode(' + ', $gig->bands->pluck('band_name')->toArray());
            $this_cover_gig[] = date('j M', strtotime($gig['datetime'])) . ' - ' . $bands;
          }

          $this_cover_gig[] = "\n\r" . str_pad('-', 40, '-');
          $gig_download[] = implode("\n\r\n\r", $this_cover_gig);
        }
      }
    }

    return Response::make(implode("\n\r\n\r\n\r", $gig_download), '200', array('Content-Type'        => 'application/octet-stream',
                                                                               'Content-Disposition' => 'attachment; filename="gig_list.txt'));
  }
}
