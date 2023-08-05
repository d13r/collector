<?php

namespace App\Http\Controllers;

class LoginController extends Controller
{
    public function __invoke()
    {
        $config = config('collector');

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === $config['username'] && password_verify($password, $config['password-hash'])) {
            $value = "$username\n{$config['password-hash']}";
        } else {
            $value = 'invalid';
        }

        send_forever_cookie('auth', $value);
        return redirect('/');
    }
}
