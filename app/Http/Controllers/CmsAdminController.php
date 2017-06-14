<?php namespace App\Http\Controllers;

use App\CmsPages;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\storeCmsAdminRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Request;

class CmsAdminController extends Controller
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
    //

    $title = 'Create New CMS Page';
    return view('admin.cms.create', compact('title'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(storeCmsAdminRequest $request)
  {
    //

    // Get the form data
    $cms_data = Request::all();

    $cms = !empty($cms_data['id'])
      ? CmsPages::find((int)$cms_data['id'])
      : CmsPages::where('title', '=', trim($cms_data['title']))->first();

    if (is_null($cms)) {
      $cms = CmsPages::firstOrCreate(['title' => trim($cms_data['title']),
                                      'url'   => insangel_case($cms_data['title'])]);
      $message = 'Page Created: ' . $cms_data['title'];
    } else {

      $message = 'Page Updated: ' . $cms_data['title'];
    }
    $cms->content = trim($cms_data['content']);
    $cms->save();

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
    $title = 'Edit CMS Page';
    $submit = 'Save Changes';
    $cms = CmsPages::findOrFail($id);

    return view('admin.cms.create', compact('title', 'cms', 'submit'));
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
    $cms = CmsPages::find($id);
    $message = $cms['title'] . ' - Page deleted';
    $cms->delete();
    return Redirect::action('GigAdminController@index')->with('message', $message);
  }

  public function list_pages()
  {
    $pages = CmsPages::all();
    return view('admin.cms.show', compact('pages'));
  }

}
