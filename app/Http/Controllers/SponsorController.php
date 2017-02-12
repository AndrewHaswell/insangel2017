<?php namespace App\Http\Controllers;

use App\Sponsor;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\storeSponsorRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Request;

class SponsorController extends Controller
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
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $title = 'Add New Sponsor';
    return view('admin.sponsor.create', compact('title'));
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
    $sponsor_data = Request::all();

    // Check URL exists

    $file_headers = @get_headers(trim($sponsor_data['link_url']));

    if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
      return Redirect::action('GigAdminController@index')->with('message', 'Create sponsor failed - URL ' . $sponsor_data['link_url'] . ' is not valid.');
    }

    $unique_id = uniqid();

    if (Request::hasFile('logo')) {
      $logo_directory = 'sponsors';
      $extension = Request::file('logo')->getClientOriginalExtension();
      Request::file('logo')->move($logo_directory, $unique_id . '.' . $extension);
      $sponsor_data['banner_url'] = $unique_id . '.' . $extension;
    }

    $sponsor = Sponsor::firstOrCreate(['banner_url' => trim($sponsor_data['banner_url']),
                                       'link_url'   => trim($sponsor_data['link_url'])]);

    $sponsor->save();

    return Redirect::action('GigAdminController@index')->with('message', 'Sponsor added');
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
    $sponsor = Sponsor::find($id);

    unlink(public_path('sponsors/'.$sponsor['banner_url']));

    $message = 'Sponsor deleted';
    $sponsor->delete();



    return Redirect::action('GigAdminController@index')->with('message', $message);
  }
}
