<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class InsangelComposer
{
  /**
   * Bind data to the view.
   *
   * @param  View $view
   *
   * @return void
   */
  public function compose(View $view)
  {
    $navigation = ['/'      => 'Gigs by Date',
                   'bands'  => 'Gigs by Band',
                   'venues' => 'Gigs by Venue',];

    $view->with('navigation', array_reverse($navigation));
  }
}