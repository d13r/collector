<?php

function logged_in()
{
    $config = config('collector');

    if (!isset($_COOKIE['auth'])) {
        return false;
    }

    $auth = explode("\n", $_COOKIE['auth']);

    return $auth[0] === $config['username'] && hash_equals($config['password-hash'], $auth[1]);
}
