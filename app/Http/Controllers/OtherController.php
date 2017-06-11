<?php

namespace App\Http\Controllers;

use App\Gig;
use App\OtherGigs;

use App\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class OtherController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    $ne_gigs = [];

    $gig_message = Session::get('gig');
    $gigs = OtherGigs::where('active', 1)->where('gigtime', '>=', Carbon::today())->get();

    if (!empty($gigs)) {
      foreach ($gigs as $gig) {

        $this_key = strtotime(date('Y-m-d', strtotime($gig['gigtime'])));

        $this_gig = [];

        $this_gig['title'] = $gig['name'];
        $this_gig['date'] = strtotime($gig['gigtime']);
        $this_gig['venue'] = $gig['venue'];
        $this_gig['cost'] = preg_replace('/[^0-9\.]/Ui', '', $gig['cost']);
        $this_gig['insangel'] = false;

        $ne_gigs[$this_key][] = $this_gig;
      }
    }

    $insangel_gigs = Gig::AllCurrentByDate()->get();

    if (!empty($insangel_gigs)) {
      foreach ($insangel_gigs as $gig) {

        $this_key = strtotime(date('Y-m-d', strtotime($gig['datetime'])));

        $this_gig = [];

        $title = '';

        $band_list = array_chunk($gig->bands->pluck('band_name')->toArray(), 3);
        if (!empty($band_list[0]) && is_array($band_list[0])) {
          $title .= implode(' / ', $band_list[0]);
        }

        $venue = $gig->venue['venue_name'];

        if (!empty($gig->venue['venue_address'])) {
          $venue .= ', ' . $gig->venue['venue_address'];
        }

        $this_gig['title'] = $title;
        $this_gig['date'] = strtotime($gig['datetime']);
        $this_gig['venue'] = $venue;
        $this_gig['cost'] = preg_replace('/[^0-9\.]/Ui', '', $gig['cost']);
        $this_gig['insangel'] = true;

        $ne_gigs[$this_key][] = $this_gig;
      }
    }

    ksort($ne_gigs);

    return view('gig.other', compact(['ne_gigs',
                                      'gig_message']));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    //dd($request);

    $this->validate($request, ['name'  => 'bail|required',
                               'venue' => 'bail|required',
                               'date'  => 'bail|required',
                               'email' => 'email'

    ]);

    $gig = new OtherGigs();

    $gig->name = $request->name;
    $gig->venue = $request->venue;
    $gig->gigtime = $request->date;

    if (!empty($request->price) && is_numeric($request->price)) {
      $gig->cost = $request->price;
    } else {
      $gig->cost = 'Free';
    }
    if (!empty($request->email)) {
      $gig->email = $request->email;
    }

    Session::flash('gig', 'Gig saved - if you have entered your email address you will be notified when the gig is live');

    $gig->save();

    return Redirect::to(url('/other'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
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
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int                      $id
   *
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
