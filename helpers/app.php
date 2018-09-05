<?php

function current_target(): string
{
    global $config;

    $current = $_COOKIE['target'] ?? null;

    if (!isset($config['targets'][$current])) {
        reset($config['targets']);
        $current = key($config['targets']);
    }

    return $current;
}

function is_current_target($target): bool
{
    return $target === current_target();
}
