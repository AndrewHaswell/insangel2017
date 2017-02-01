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
}
