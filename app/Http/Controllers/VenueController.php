<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{

  public function index()
  {
    $venues = Venue::AllCurrentByDate()->get();
    return view('venue.show', compact('venues'));
  }

  public function add_seo_name()
  {
    $venues = Venue::all();
    foreach ($venues as $venue) {
      $venue->seo_name = camel_case(strtolower(preg_replace('/[^a-z0-9]/i', '_', $venue['venue_name'])));
      $venue->save();
    }
  }
}
