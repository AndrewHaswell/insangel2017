<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVenuesTable extends Migration
{

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('venues', function (Blueprint $table) {
      $table->increments('id');
      $table->string('venue_name', 200);
      $table->text('venue_description');
      $table->text('venue_logo');
      $table->text('venue_address');
      $table->text('venue_telephone');
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
    Schema::drop('venues');
  }
}
