<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\URL;
use App\Http\Requests;
use App\Gig;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Illuminate\Support\Facades\Auth;

class PosterAdminController extends Controller
{
  /**
   * Create a poster for the gig
   *
   * @param int $gig_id
   * @param int $plain
   *
   * @author Andrew Haswell
   */

  function make_poster($gig_id = 1, $plain = 0)
  {
    $poster_file_name = $plain
      ? 'posters/' . $gig_id . '_1.jpg'
      : 'posters/' . $gig_id . '.jpg';
    $poster_file = public_path($poster_file_name);

    $white = $plain
      ? '#444'
      : '#fff';

    $title_col = $plain
      ? '#f00'
      : '#fff';

    $colour = $plain
      ? '#000'
      : '#cfc';

    // If we're not an admin, check to see if the file exists first
    if (!Auth::check() && file_exists($poster_file)) {
      header('Content-type:image/jpg');
      readfile(URL::asset($poster_file_name));
    }

    // +---
    // | Load the Gig before we do anything else
    // +---

    $gig = Gig::findorfail($gig_id);

    // +---
    // | Load the default background image
    // +---
    $background = $plain
      ? 'images/background-light.png'
      : 'images/background.png';
    $img = Image::make(URL::asset($background))->resize(1240, 1754);

    // +---
    // | Add the Insangel logo
    // +---
    $insangel = $plain
      ? 'images/insangel-logo-colour.png'
      : 'images/insangel-logo-white.png';
    $insangel_logo = Image::make(URL::asset($insangel))->resize(750, null, function ($constraint) {
      $constraint->aspectRatio();
    });
    $img->insert($insangel_logo, 'top', 0, 100);

    // +---
    // | Check whether we need an image banner, a text banner or none
    // +---

    // Set the default subtitle position first
    $subtitle_position = 660;

    // If we have a gig title, then decide what to do with it
    if (!empty($gig['title'])) {

      $title = strtolower(trim($gig['title']));

      // Is it an introduces gig?
      if (substr($title, 0, 19) == 'insangel introduces') {
        $banner = Image::make(URL::asset('images/introducing.png'))->resize(650, null, function ($constraint) {
          $constraint->aspectRatio();
        });
        $img->insert($banner, 'top', 0, 430);
      } else {
        // There's no more image banner, so fall back to text
        $banner = Image::canvas(1240, 120, 'rgba(0, 0, 0, 0.7)');
        $img->insert($banner, 'top', 0, 470);
        $img->text(strtoupper($gig['title']), 620, 558, function ($font) use ($title_col) {
          $font->file(public_path('fonts/FuturaLT-Bold.ttf'));
          $font->size(65);
          $font->color($title_col);
          $font->align('center');
        });
      }
    } else {
      // We don't have any kind of gig title, so move the subtitle slightly
      $subtitle_position = 580;
    }

    // +---
    // | Add the subtitle
    // +---

    $subtitle = !empty($gig['subtitle'])
      ? $gig['subtitle']
      : 'music to your beers';

    $img->text('"' . strtolower($subtitle) . '"', 620, $subtitle_position, function ($font) use ($white) {
      $font->file(public_path('fonts/FuturaLT-Book.ttf'));
      $font->size(40);
      $font->color($white);
      $font->align('center');
    });

    // +---
    // | Add the website footer
    // +---

    $img->text(strtoupper('www.insangel.co.uk'), 620, 1595, function ($font) use ($white) {
      $font->file(public_path('fonts/FuturaLT-Book.ttf'));
      $font->size(40);
      $font->color($white);
      $font->align('center');
    });

    // +---
    // | Add the venue name
    // +---

    $venue = $gig->venue['venue_name'];

    $box_size = $this->text_size($venue);
    $venue_img = Image::canvas($box_size['x'] + 10, $box_size['y'] + 10);

    $venue_img->text(strtolower($venue), 5, 5, function ($font) use ($colour) {
      $font->file(public_path('fonts/Plane Crash.ttf'));
      $font->size(100);
      $font->color($colour);
      $font->valign('top');
    });

    $venue_img->resize(1000, null, function ($constraint) {
      $constraint->aspectRatio();
      $constraint->upsize();
    });

    $venue_height = $venue_img->height();

    $img->insert($venue_img, 'top', 620, 1405 - $venue_height);

    // +---
    // | Add the gig date details
    // +---

    $gig_date = Carbon::parse($gig->datetime);
    $time = $gig_date->format('g:ia');
    $date = $gig_date->formatLocalized('%A %d %B %Y');

    $img->text(strtoupper($date), 620, 1370 - $venue_height, function ($font) use ($white) {
      $font->file(public_path('fonts/FuturaLT-Book.ttf'));
      $font->size(70);
      $font->color($white);
      $font->align('center');
    });

    // +---
    // | Add the venue time and costs
    // +---

    $cost = $gig->cost;

    if (!empty($cost) && is_numeric($cost)) {
      $cost = '£' . $cost;
    }

    $img->text(strtoupper('Starts at ' . $time . ' - ' . $cost), 620, 1495, function ($font) use ($white) {
      $font->file(public_path('fonts/FuturaLT-Book.ttf'));
      $font->size(60);
      $font->color($white);
      $font->align('center');
    });

    // +---
    // | Add the band names
    // +---

    // Set some defaults
    $band_top = $subtitle_position + 60;
    $band_bottom = 1230 - $venue_height;
    $band_padding = 60;
    $band_size = 140;

    // Get the band names
    $band_list = $gig->bands->pluck('band_name')->toArray();

    // +---
    // | Work out the size we have for the band names
    // +---

    $band_area = ['x' => 0,
                  'y' => 0];
    $area = [];

    foreach ($band_list as $band_name) {
      $this_band_area = $this->text_size($band_name, $band_size, 'FuturaLT-CondensedExtraBold.ttf', true);
      $band_area['y'] += $this_band_area['y'] + $band_padding;
      if ($this_band_area['x'] > $band_area['x']) {
        $band_area['x'] = $this_band_area['x'];
      }
      $area[$band_name] = $this_band_area;
    }

    // +---
    // | Now we have our sizes, create a blank canvas and add the names
    // +---

    $band_canvas = Image::canvas($band_area['x'], $band_area['y'] - $band_padding);
    $current_height = 0;

    foreach ($band_list as $band_name) {
      $current_height += ($area[$band_name]['y']);
      $band_canvas->text(strtoupper($band_name), ceil($band_area['x'] / 2), $current_height, function ($font) use ($band_size, $colour) {
        $font->file(public_path('fonts/FuturaLT-CondensedExtraBold.ttf'));
        $font->size($band_size);
        $font->color($colour);
        $font->align('center');
      });
      $current_height += $band_padding;
    }

    // +---
    // | Work out our new canvas size and decide whether to resize for the final poster
    // +---

    $band_canvas_height = $band_canvas->height();
    $band_canvas_width = $band_canvas->width();

    // First check if the band canvas is too wide
    if ($band_canvas_width > 1140) {
      $ratio = 1140 / $band_canvas_width;
      $band_canvas_height = (int)ceil($band_canvas_height * $ratio);
      $band_canvas_width = (int)ceil($band_canvas_width * $ratio);
    }

    // Second check if the band canvas is too tall
    if ($band_canvas_height > ($band_bottom - $band_top)) {
      $ratio = ($band_bottom - $band_top) / $band_canvas_height;
      $band_canvas_height = (int)ceil($band_canvas_height * $ratio);
      $band_canvas_width = (int)ceil($band_canvas_width * $ratio);
    }

    // If we have any height difference, work it out for positioning
    $height_diff = ($band_bottom - $band_top) - $band_canvas_height;
    $height_diff = $height_diff > 2
      ? (int)ceil($height_diff / 2)
      : 0;

    // Resize the band canvas
    $band_canvas->resize($band_canvas_width, $band_canvas_height);

    // Add the bands to the poster
    $img->insert($band_canvas, 'top', 620, $band_top + $height_diff);

    // +---
    // | Do we want to add QR codes for links?
    // +---

    $links = $gig['links'];

    if (!empty($links)) {
      $link = explode(',', $links);
      $qrCode = new QrCode();
      $qrCode->setText(current($link))->setSize(175)->setPadding(10)->setErrorCorrection('high');
      $qrCode->setForegroundColor(['r' => 0,
                                   'g' => 0,
                                   'b' => 0,
                                   'a' => 0]);
      $qrCode->setBackgroundColor(['r' => 255,
                                   'g' => 255,
                                   'b' => 255,
                                   'a' => 0]);
      $qrCode->setImageType(QrCode::IMAGE_TYPE_PNG)->save('posters/qrcode_' . $gig_id . '.png');
      $qr_code_img = Image::make(URL::asset('posters/qrcode_' . $gig_id . '.png'));
      $img->insert($qr_code_img, 'bottom-right', 25, 25);
    }

    // +---
    // | Output the finished image
    // +---

    $img->save($poster_file_name);
    header('Content-type:image/jpg');
    readfile(URL::asset($poster_file_name));
  }

  /**
   * Work out the size needed for a text image
   *
   * @param        $text
   * @param int    $size
   * @param string $font
   *
   * @return array
   * @author Andrew Haswell
   */

  public function text_size($text, $size = 100, $font = 'Plane Crash.ttf', $uppercase = false)
  {
    // Work out roughly pixels to points
    $size = ($size * 3) / 4;

    // What case are we using?
    $text = $uppercase
      ? strtoupper($text)
      : strtolower($text);

    // Get the x,y co-ordinates for the box
    $box = imagettfbbox($size, 0, public_path('fonts/' . $font), $text);

    // Pull it out into height and width
    $width = abs($box[4] - $box[0]);
    $height = abs($box[5] - $box[1]);

    // Return the results
    return ['x' => $width,
            'y' => $height];
  }
}
