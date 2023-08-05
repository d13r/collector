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
