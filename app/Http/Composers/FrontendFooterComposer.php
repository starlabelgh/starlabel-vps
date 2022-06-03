<?php

namespace App\Http\Composers;

use App\Models\Page;
use Illuminate\View\View;

class FrontendFooterComposer
{
    public function compose(View $view)
    {
        $view->with('footermenus', Page::all());
    }
}
