<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Gig;

class Venue extends Model
{

  protected $fillable = ['venue_name',
                         'seo_name',
                         'title',
                         'subtitle',
                         'datetime',
                         'cost'];

  public function gigs()
  {
    return $this->hasMany('App\Gig');
  }

  public function scopeTest($query)
  {
    return $query->with(['gigs',
                         'gigs.bands']);
  }

  public function scopeAllCurrentByDate($query)
  {
    return $query->with(['gigs' => function ($w) {
      $w->where('datetime', '>=', Carbon::today())->orderBy('datetime', 'asc');
    },
                         'gigs.bands'])->whereHas('gigs', function ($wh) {
      $wh->where('datetime', '>=', Carbon::today());
    })->orderBy('venue_name', 'asc');
  }

  public function scopeAllCoverVenues($query)
  {
    return $query->with(['gigs' => function ($w) {
      $w->where('datetime', '>=', Carbon::today())->where('cover', '=', 'Y')->orderBy('datetime', 'asc');
    },
                         'gigs.bands'])->orderBy('venue_name', 'asc');
  }

}
