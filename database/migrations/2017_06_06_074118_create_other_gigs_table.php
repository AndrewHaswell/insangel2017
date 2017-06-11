<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherGigsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('other_gigs', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('venue');
      $table->dateTime('gigtime');
      $table->string('cost', 150);
      $table->string('email');
      $table->boolean('active');
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
    Schema::drop('other_gigs');
  }
}
