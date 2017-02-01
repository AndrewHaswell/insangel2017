<?php namespace App\Http\Controllers;

use App\Gig;
use App\Band;
use App\Venue;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GigController extends Controller
{

  public function index()
  {
    $gigs = Gig::AllCurrentByDate()->get();
    $cover_gigs = Venue::AllCoverVenues()->get();

   // return $cover_gigs;

    return view('gig.show', compact('gigs','cover_gigs'));
  }
}
