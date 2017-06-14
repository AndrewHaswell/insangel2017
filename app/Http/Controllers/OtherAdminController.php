<?php

namespace App\Http\Controllers;

use App\OtherGigs;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class OtherAdminController extends Controller
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
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $other_gigs = OtherGigs::where('active', 0)->get();
    return view('admin.other.approve', compact('other_gigs'));
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
    // If we have anything to approve, do it
    if (!empty($request->approve)) {
      $approve = $request->approve;

      $approve_emails = DB::table('other_gigs')->select('email')->whereIn('id', $approve)->where('email', '!=', '')->groupBy('email')->get();
      foreach ($approve_emails as $email) {

        $email = (string)$email->email;
/*
        Mail::send('gig.email', ['type' => 'approve'], function ($message) use ($email) {
          $message->from('phil@insangel.co.uk', 'Insangel');
          $message->to($email);
          $message->subject('Gigs Approved');
        });*/
      }

      OtherGigs::whereIn('id', $approve)->update(['active' => 1]);
    }

    // Or if we have any to delete, then remove it
    if (!empty($request->delete)) {
      $delete = $request->delete;
      DB::table('other_gigs')->whereIn('id', $delete)->delete();
    }
    return Redirect::to(url('/admin'));
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
