<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\CmsPages;

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

    $extra_pages = CmsPages::all();

    if (!empty($extra_pages)) {
      foreach ($extra_pages as $page) {
        $navigation['pages/' . $page->url] = $page->title;
      }
    }

    $view->with('navigation', array_reverse($navigation));
  }
}