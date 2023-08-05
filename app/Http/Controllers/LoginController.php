<?php

namespace App\Http\Controllers;

use Cookie;
use Session;

class LoginController extends Controller
{
    public function __invoke()
    {
        $username = request('username');
        $password = request('password');
        $hash = config('collector.password-hash');

        if ($username && $password && $username === config('collector.username') && password_verify($password, $hash)) {
            $value = "$username\n$hash";
        } else {
            $value = 'invalid';
        }

        Session::regenerate(true);
        Cookie::queue(Cookie::forever('auth', $value));

        return redirect('/');
    }
}
