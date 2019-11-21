<?php

function asset_url($file)
{
    $path = base_path("www/assets/$file");

    $hash = md5_file($path);

    return "/assets/$hash/$file";
}
