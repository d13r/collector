<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class MessageController extends Controller
{
    public function __invoke()
    {
        if (!logged_in()) {
            return response(view('login'), Response::HTTP_FORBIDDEN);
        }

        $targets = config('collector.targets');

        return view('message', compact('targets'));
    }
}
