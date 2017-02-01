<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
  protected $fillable = ['band_name',
                         'band_description',
                         'band_logo'];

  /**
   * @param $value
   * @author Andrew Haswell
   */

  public function setBandNameAttribute($value)
  {
    $this->attributes['band_name'] = $value ?: 'TBC';
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   * @author Andrew Haswell
   */
  public function gigs()
  {
    return $this->belongsToMany('App\Gig');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   * @author Andrew Haswell
   */
  public function images()
  {
    return $this->hasMany('App\Band_image');
  }

  /**
   * @param $query
   * @return mixed
   * @author Andrew Haswell
   */
  public function scopeAllCurrentByDate($query)
  {
    return $query->with(['gigs' => function ($w) {
      $w->where('datetime', '>=', Carbon::today());
    }, 'gigs.venue'])->whereHas('gigs', function ($wh) {
      $wh->where('datetime', '>=', Carbon::today());
    })->orderBy('band_name', 'asc');
  }
}
