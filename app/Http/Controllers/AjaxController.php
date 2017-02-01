<?php namespace App\Http\Controllers;

use App\Band;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AjaxController extends Controller
{

  /**
   * @param $count
   * @return \Illuminate\View\View
   * @author Andrew Haswell
   */
  public function band_drop_downs($count)
  {
    $bands = Band::all(['id',
                        'band_name'])->keyBy('band_name')->toArray();

    array_walk($bands, function (&$value) { $value = $value['band_name']; });
    array_unshift($bands, '');

    return view('ajax.bands', compact('bands', 'count'));
  }
}
