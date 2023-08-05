<?php

namespace App\Http\Controllers;

use App\Mail\CollectorMessage;
use Cookie;
use Mail;
use Session;

class SendController extends Controller
{
    public function __invoke()
    {
        // Check authentication
        if (!logged_in()) {
            return ['error' => 'You are not logged in. Please refresh the page and try again'];
        }

        // Special logout command
        $message = trim(request('message'));

        if ($message === '/logout') {
            Session::regenerate(true);
            Cookie::queue(Cookie::forget('auth'));
            return ['refresh' => true];
        }

        // Check target
        $targets = config('collector.targets');
        $targetId = request('target');

        if (!isset($targets[$targetId])) {
            return ['error' => 'No target selected'];
        }

        $target = $targets[$targetId];

        Cookie::queue(Cookie::forever('target', $targetId));

        // Send email
        if (!$message) {
            return ['error' => 'Please enter a message'];
        }


        Mail::send(new CollectorMessage($target, $message));

        // Send response
        return ['success' => 'Message Sent'];
    }
}
