<?php

function asset_url($file): string
{
    $hash = md5_file(base_path("public/assets/$file"));

    return asset("assets/$hash/$file");
}
