<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class GlobalComposer
{
    public function compose(View $view)
    {
        if (Auth::check()) {

        }
    }
}
