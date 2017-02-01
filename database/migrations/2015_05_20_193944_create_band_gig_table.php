<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBandGigTable extends Migration
{

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('band_gig', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('band_id')->unsigned()->index();
      $table->foreign('band_id')->references('id')->on('bands')->onDelete('cascade');
      $table->integer('gig_id')->unsigned();
      $table->foreign('gig_id')->references('id')->on('gigs')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('band_gig');
  }
}
