<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
  protected $fillable = ['banner_url',
                         'link_url'];
}