<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherGigs extends Model
{
  public function scopeAllCurrentByDate($query)
  {
    return $query->where('datetime', '>=', Carbon::today())->where('cover', '!=', 'Y')->with('bands')->with('venue')->orderBy('datetime', 'asc');
  }
}
