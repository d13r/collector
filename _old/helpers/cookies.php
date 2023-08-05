<?php

function send_forever_cookie($name, $value): void
{
    setcookie($name, $value, 2147483647, '/', '', true, true);
}
