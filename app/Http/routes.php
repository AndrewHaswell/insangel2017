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

Route::get('/', 'GigController@index');
Route::get('/seo', 'BandController@add_seo_name');
Route::get('/bands/{name}', 'BandController@band_details');
Route::get('/pages/{name}', 'CmsPagesController@index');
Route::get('/venues/{name}', 'VenueController@venue_details');
Route::get('/bands', 'BandController@index');
Route::get('/venues', 'VenueController@index');
Route::get('ajax/bands/{count}', 'AjaxController@band_drop_downs');
Route::get('admin', 'GigAdminController@index');
Route::get('admin/download', 'GigController@gig_list');
Route::get('download', 'GigController@gig_list')->name('gig_list');
Route::get('admin/poster/{id}', 'PosterAdminController@make_poster');
Route::get('poster/{id}', 'PosterAdminController@make_poster')->name('posters');;
Route::get('admin/cms/list_pages', 'CmsAdminController@list_pages');

Route::get('auth/register', function () {
  return View::make('errors.404');
});

Route::post('auth/register', function () {
  return View::make('errors.404');
});

Route::resource('admin/gig', 'GigAdminController');
Route::resource('admin/sponsor', 'SponsorController');
Route::resource('admin/band', 'BandAdminController');
Route::resource('admin/venue', 'VenueAdminController');
Route::resource('admin/cms', 'CmsAdminController');
Route::resource('admin/upload', 'UploadAdminController');

Route::controllers(['auth'     => 'Auth\AuthController',
                    'password' => 'Auth\PasswordController',]);
