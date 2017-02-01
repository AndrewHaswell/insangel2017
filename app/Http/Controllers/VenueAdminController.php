<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Venue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Request;

class VenueAdminController extends Controller
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
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $title = 'Create New Venue';
    return view('admin.venue.create', compact('title'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    // Get the form data
    $venue_data = Request::all();

    if (!empty($venue_data['name']) && Request::hasFile('logo')) {
      $logo_directory = 'downloads/venue_logos';
      // Remove any old venue logos that may exist
      $existing = glob($logo_directory . '/' . camel_case($venue_data['name'] . '*'));
      if (!empty($existing) && is_array($existing)) {
        foreach ($existing as $old_logo) {
          unlink($old_logo);
        }
      }
      $extension = Request::file('logo')->getClientOriginalExtension();
      Request::file('logo')->move('downloads/venue_logos', camel_case($venue_data['name'] . '.' . $extension));
      $venue_data['logo'] = camel_case($venue_data['name'] . '.' . $extension);
    }

    $venue = Venue::where('venue_name', '=', trim($venue_data['name']))->first();
    if (is_null($venue)) {
      $venue = Venue::firstOrCreate(['venue_name' => trim($venue_data['name']),
                                     'seo_name'   => camel_case(strtolower(preg_replace('/[^a-z0-9]/i', '_', $venue_data['name'])))]);
      $message = 'Venue Created: ' . $venue_data['name'];
    } else {
      $message = 'Venue Edited: ' . $venue_data['name'];
    }

    if (!empty($venue_data['name'])) {
      $venue->seo_name = camel_case(strtolower(preg_replace('/[^a-z0-9]/i', '_', $venue_data['name'])));
    }
    if (!empty($venue_data['description'])) {
      $venue->venue_description = $venue_data['description'];
    }
    if (!empty($venue_data['address'])) {
      $venue->venue_address = $venue_data['address'];
    }
    if (!empty($venue_data['telephone'])) {
      $venue->venue_telephone = $venue_data['telephone'];
    }
    if (!empty($venue_data['logo'])) {
      $venue->venue_logo = $venue_data['logo'];
    }

    $venue->save();

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
    $title = 'Edit Venue';
    $submit = 'Save Changes';

    $venue = Venue::findOrFail($id);

    return view('admin.venue.create', compact('title', 'venue', 'submit'));
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
