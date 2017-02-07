<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinksToBandsAndVenues extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('bands', function (Blueprint $table) {
      $table->string('links')->after('band_logo');
    });
    Schema::table('venues', function (Blueprint $table) {
      $table->string('links')->after('venue_telephone');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('bands', function (Blueprint $table) {
      $table->dropColumn('links');
    });
    Schema::table('venues', function (Blueprint $table) {
      $table->dropColumn('links');
    });
  }
}
