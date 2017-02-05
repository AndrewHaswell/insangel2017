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

  public function venue_details($name)
  {
    $venue = Venue::where('seo_name', $name)->firstOrFail();
    return view('venue.details', compact('venue'));
  }

  public function add_seo_name()
  {
    $venues = Venue::all();
    foreach ($venues as $venue) {
      $venue->seo_name = insangel_case($venue['venue_name']);
      $venue->save();
    }
  }
}
