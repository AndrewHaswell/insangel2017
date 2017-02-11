<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\URL;
use App\Http\Requests;
use App\Gig;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;

class PosterAdminController extends Controller
{
  function make_poster($gig_id = 2)
  {

    $gig = Gig::findorfail($gig_id);

    $links = $gig['links'];
    $has_qr = false;

    if (0 && !empty($links)) {
      $link = explode(',', $links);
      $qrCode = new QrCode();
      $qrCode->setText(current($link))->setSize(150)->setPadding(10)->setErrorCorrection('high');
      $qrCode->setForegroundColor(['r' => 0,
                                   'g' => 0,
                                   'b' => 0,
                                   'a' => 0]);
      $qrCode->setBackgroundColor(['r' => 255,
                                   'g' => 255,
                                   'b' => 255,
                                   'a' => 0]);
      $qrCode->setImageType(QrCode::IMAGE_TYPE_PNG)->save('posters/qrcode_' . $gig_id . '.png');
      $has_qr = true;
    }

    $img = Image::make(URL::asset('images/background.png'))->resize(1240, 1754);
    //   $img = Image::make(URL::asset('images/insangelintroduces.png'))->resize(1240, 1754);

    $venue = $gig->venue['venue_name'];

    $img->text(strtolower($venue), 625, 265, function ($font) {
      $font->file(public_path('fonts/Plane Crash.ttf'));
      $font->size(65);
      $font->color('#000');
      $font->align('center');
    });
    $img->text(strtolower($venue), 620, 260, function ($font) {
      $font->file(public_path('fonts/Plane Crash.ttf'));
      $font->size(65);
      $font->color('#fff');
      $font->align('center');
    });

    $insangel_logo = Image::make(URL::asset('images/insangel-logo-white.png'))->resize(1180, null, function ($constraint) {
      $constraint->aspectRatio();
    });
    $img->insert($insangel_logo, 'top', 0, 230);

    $subtitle_position = 1010;

    // Do we need a banner

    if (!empty($gig['title'])) {

      $title = strtolower(trim($gig['title']));

      if (substr($title, 0, 19) == 'insangel introduces') {
        $banner = Image::make(URL::asset('images/introducing.png'))->resize(830, null, function ($constraint) {
          $constraint->aspectRatio();
        });

        $img->insert($banner, 'top', 0, 750);
      } else {

        $banner = Image::canvas(1240, 120, 'rgba(0, 0, 0, 0.5)');
        $img->insert($banner, 'top', 0, 810);

        $img->text(strtoupper($gig['title']), 620, 900, function ($font) {
          $font->file(public_path('fonts/FuturaLT-Bold.ttf'));
          $font->size(65);
          $font->color('#fff');
          $font->align('center');
        });
      }
    } else {
      $subtitle_position = 960;
    }

    $subtitle = !empty($gig['subtitle'])
      ? $gig['subtitle']
      : 'showcasing live music in the north east';

    $img->text('"' . strtolower($subtitle) . '"', 620, $subtitle_position, function ($font) {
      $font->file(public_path('fonts/FuturaLT-Book.ttf'));
      $font->size(40);
      $font->color('#fff');
      $font->align('center');
    });

    //dd($gig);

    $gig_date = Carbon::parse($gig->datetime);
    $time = $gig_date->format('g:ia');
    $date = $gig_date->formatLocalized('%A %d %B %Y');

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
                                         1457],
                      'band_count_3' => [1290,
                                         1397,
                                         1507],
                      'band_count_4' => [1260,
                                         1348,
                                         1433,
                                         1520,]];

    $band_size = ['band_count_1' => 88,
                  'band_count_2' => 100,
                  'band_count_3' => 88,
                  'band_count_4' => 65];

    $band_list = $gig->bands->pluck('band_name')->toArray();

    $band_count = count($band_list);

    if ($band_count > 4) {
      $band_list = array_slice($band_list, 0, 4);
      $band_count = 4;
    }

    $count = 0;

    foreach ($band_list as $band_name) {

      $color = $count > 0 && $count % 2 != 0
        ? '#fff'
        : '#ddd';

      $img->text(strtoupper($band_name), 620, $band_position['band_count_' . $band_count][$count], function ($font) use ($band_size, $band_count, $color) {
        $font->file(public_path('fonts/FuturaLT-CondensedExtraBold.ttf'));
        $font->size($band_size['band_count_' . $band_count]);
        $font->color($color);
        $font->align('center');
      });
      $count++;
    }

    if ($has_qr) {
      $qrcodeimg = Image::make(URL::asset('posters/qrcode_' . $gig_id . '.png'));
      $img->insert($qrcodeimg, 'bottom-right', 25, 25);
    }

    $img->save('posters/' . $gig_id . '.jpg');

    header('Content-type:image/jpg');
    readfile(URL::asset('posters/' . $gig_id . '.jpg'));
  }
}
