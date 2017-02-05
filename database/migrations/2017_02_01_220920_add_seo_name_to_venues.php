<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Venue;

class AddSeoNameToVenues extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('venues', function ($table) {
      $table->string('seo_name')->after('venue_name');
    });

    \App::call('App\Http\Controllers\VenueController@add_seo_name');
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('venues', function ($table) {
      $table->dropColumn('seo_name');
    });
  }
}
