<?php

function asset_url($file)
{
    $path = base_path("public/assets/$file");

    $hash = md5_file($path);

    return "/assets/$hash/$file";
}
