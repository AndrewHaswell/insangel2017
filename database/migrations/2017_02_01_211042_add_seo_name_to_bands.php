<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Band;

class AddSeoNameToBands extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('bands', function ($table) {
      $table->string('seo_name')->after('band_name');
    });

    \App::call('App\Http\Controllers\BandController@add_seo_name');
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('bands', function ($table) {
      $table->dropColumn('seo_name');
    });
  }
}
