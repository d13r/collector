<?php

namespace App\Http\Controllers;

class GuiController extends Controller
{
    public function __invoke()
    {
        $config = config('collector');

        return view('gui', compact('config'));
    }
}
