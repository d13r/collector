<?php

function base_path($path = null)
{
    global $basePath;

    return $basePath . ($path ? "/$path" : '');
}
