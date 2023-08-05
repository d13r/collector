<?php

function checked($value, $expected = null): string
{
    if ($expected === null) {
        $checked = $value;
    } else {
        $checked = ($value === $expected);
    }

    return $checked ? 'checked' : '';
}

function e($text): string
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5);
}
