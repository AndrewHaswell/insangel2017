<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGigsTable extends Migration
{

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('gigs', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('venue_id');
      $table->string('title', 150);
      $table->string('subtitle', 150);
      $table->string('cost', 150);
      $table->string('notes', 75);
      $table->datetime('datetime');
      $table->enum('cover', array('Y', 'N'))->default('N');
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
    Schema::drop('gigs');
  }
}
