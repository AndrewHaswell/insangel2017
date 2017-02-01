<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Intervention\Image\Facades\Image;

Route::get('/', 'GigController@index');

Route::get('/pic2', function () {

  //return public_path('fonts/Across the Road.ttf');

  $img = Image::canvas(250, 30, '#000');



  // use callback to define details
  $img->text('Gigs by Band', 125,14, function($font) {
    $font->file(public_path('fonts/Impact Label Reversed.ttf'));
    $font->size(26);
    $font->color('#fff');
    $font->align('center');
    $font->valign('center');
  });

  //$img->blur();

  return $img->response('png');
});



Route::get('/seo', 'BandController@add_seo_name');
Route::get('/bands/{name}', 'BandController@band_details');
Route::get('/bands', 'BandController@index');
Route::get('/venues', 'VenueController@index');

Route::get('admin/download', 'GigAdminController@gig_list');

Route::resource('admin/gig', 'GigAdminController');
Route::resource('admin/band', 'BandAdminController');
Route::resource('admin/venue', 'VenueAdminController');
Route::resource('admin/cms', 'CmsAdminController');
Route::resource('admin/upload', 'UploadAdminController');

Route::get('ajax/bands/{count}', 'AjaxController@band_drop_downs');
Route::get('admin', 'GigAdminController@index');

Route::controllers(['auth'     => 'Auth\AuthController',
                    'password' => 'Auth\PasswordController',]);
