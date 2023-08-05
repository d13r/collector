<?php

foreach (glob(__DIR__ . '/*.php') as $_file) {
    require_once $_file;
}

