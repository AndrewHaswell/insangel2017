<?php namespace App\Http\Controllers;

use App\CmsPages;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class CmsPagesController extends Controller
{

  public function index($url)
  {

    $page = CmsPages::where('url', $url)->firstOrFail();


    return view('cms.show', compact('page'));
  }
}
