<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\URL;
use App\Http\Requests;
use App\Gig;
use Carbon\Carbon;

class PosterAdminController extends Controller
{
  function make_poster($gig_id = 2)
  {
    $img = Image::make(URL::asset('images/background.png'))->resize(1240, 1754);

    $venue = Image::make(URL::asset('images/arizona.png'))->resize(750, null, function ($constraint) {
      $constraint->aspectRatio();
    });

    $insangel_logo = Image::make(URL::asset('images/insangel-logo-white.png'))->resize(1180, null, function ($constraint) {
      $constraint->aspectRatio();
    });

    $introducing = Image::make(URL::asset('images/introducing.png'))->resize(830, null, function ($constraint) {
      $constraint->aspectRatio();
    });

    $img->insert($insangel_logo, 'top', 0, 250);
    $img->insert($introducing, 'top', 0, 800);
    $img->insert($venue, 'top', 0, 130);

    $gig = Gig::findorfail($gig_id);

    //dd($gig);

    $gig_date = Carbon::parse($gig->datetime);
    $time = $gig_date->format('g:ia');
    $date = $gig_date->formatLocalized('%A %d %B %Y');

    // use callback to define details
    $img->text(strtoupper($date), 620, 1120, function ($font) {
      $font->file(public_path('fonts/FuturaLT-Book.ttf'));
      $font->size(60);
      $font->color('#fff');
      $font->align('center');
    });

    $cost = $gig->cost;

    if (!empty($cost) && is_numeric($cost)) {
      $cost = '£' . $cost;
    }

    $img->text(strtoupper('Starts at ' . $time . ' - ' . $cost), 620, 1165, function ($font) {
      $font->file(public_path('fonts/FuturaLT-Book.ttf'));
      $font->size(40);
      $font->color('#fff');
      $font->align('center');
    });

    $img->text(strtoupper('www.insangel.co.uk'), 620, 1595, function ($font) {
      $font->file(public_path('fonts/FuturaLT-Book.ttf'));
      $font->size(40);
      $font->color('#fff');
      $font->align('center');
    });

    $band_position = ['band_count_1' => [1390],
                      'band_count_2' => [1330,
                                         1437],
                      'band_count_3' => [1290,
                                         1397,
                                         1507],
                      'band_count_4' => [1270,
                                         1358,
                                         1443,
                                         1530,]];

    $band_list = $gig->bands->pluck('band_name')->toArray();
    $band_count = count($band_list);
    $count = 0;

    foreach ($band_list as $band_name) {

      $color = $count > 0 && $count % 2 != 0
        ? '#fff'
        : '#ddd';

      $img->text(strtoupper($band_name), 620, $band_position['band_count_' . $band_count][$count], function ($font) use ($color) {
        $font->file(public_path('fonts/FuturaLT-CondensedExtraBold.ttf'));
        $font->size(88);
        $font->color($color);
        $font->align('center');
      });
      $count++;
    }

    $img->save('posters/' . $gig_id . '.jpg');
    echo '<img src="' . URL::asset('posters/' . $gig_id . '.jpg') . '"/>';
  }
}
