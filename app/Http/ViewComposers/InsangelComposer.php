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

    $navigation = ['/'      => 'Insangel Gigs',
                   'other'  => 'North East Gigs',
                   'bands'  => 'Bands',
                   'venues' => 'Venues',];

    $extra_pages = CmsPages::all();

    if (!empty($extra_pages)) {
      foreach ($extra_pages as $page) {
        $navigation['pages/' . $page->url] = $page->title;
      }
    }

    $view->with('navigation', $navigation);
  }
}