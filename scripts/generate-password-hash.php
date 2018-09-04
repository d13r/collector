#!/usr/bin/env php
<?php

$password = readline('Enter password: ');

if ($password) {
    echo "\n";
    echo password_hash($password, PASSWORD_DEFAULT) . "\n";
}
