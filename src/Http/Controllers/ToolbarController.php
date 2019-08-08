<?php

namespace Fruitcake\TelescopeToolbar\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;

class ToolbarController extends Controller
{

    public function render($token)
    {
        return View::make('telescope-toolbar::toolbar', [
            'token' => $token,
        ]);
    }
}