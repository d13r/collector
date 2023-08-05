<?php

function logged_in()
{
    global $config;

    if (!isset($_COOKIE['auth'])) {
        return false;
    }

    $auth = explode("\n", $_COOKIE['auth']);

    return $auth[0] === $config['username'] && hash_equals($config['password-hash'], $auth[1]);
}
