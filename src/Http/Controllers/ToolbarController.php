<?php

namespace Fruitcake\TelescopeToolbar\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Laravel\Telescope\Telescope;

class ToolbarController extends Controller
{
    public function render($token)
    {
        Telescope::stopRecording();

        return View::make('telescope-toolbar::toolbar', [
            'token' => $token,
        ]);
    }
}