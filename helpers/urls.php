<?php

function asset_url($file)
{
    $path = base_path("public/assets/$file");

    $hash = md5(file_get_contents($path));

    return "/assets/$hash/$file";
}
