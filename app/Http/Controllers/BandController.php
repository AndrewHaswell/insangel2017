<?php namespace App\Http\Controllers;

use App\Band;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class BandController extends Controller
{

  /**
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   * @author Andrew Haswell
   */

  public function index()
  {
    $bands = Band::AllCurrentByDate()->where('band_name', '!=', 'TBC')->get();
    return view('band.show', compact('bands'));
  }

  /**
   * @param $name
   *
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   * @author Andrew Haswell
   */

  public function band_details($name)
  {
    $band = Band::AllCurrentByDate()->where('seo_name', $name)->firstOrFail();
    return view('band.details', compact('band'));
  }

  /**
   * Add seo name to bands table for migration
   *
   * @author Andrew Haswell
   */

  public function add_seo_name()
  {
    $bands = Band::all();
    foreach ($bands as $band) {
      $band->seo_name = insangel_case($band['band_name']);
      $band->save();
    }
  }
}
