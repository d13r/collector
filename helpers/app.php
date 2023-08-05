<?php

function current_target(): string
{
    $targets = config('collector.targets');
    $current = request('target') ?? Cookie::get('target');

    if (!isset($targets[$current])) {
        $current = array_key_first($targets);
    }

    return $current;
}

function is_current_target(string $target): bool
{
    return $target === current_target();
}
