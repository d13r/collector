<?php

function logged_in(): bool
{
    $cookie = Cookie::get('auth', '');
    $expected = config('collector.username') . "\n" . config('collector.password-hash');

    return hash_equals($expected, $cookie);
}
