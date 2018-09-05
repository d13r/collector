<?php

return [

    // Username
    'username' => '',

    // Password hash (run scripts/generate-password-hash.php)
    'password-hash' => '',

    // Targets
    'targets' => [

        'home' => [
            'title' => 'Home',
            'shortcut' => 'h',
            'from' => '"Your name" <your@email.com>',
            'to' => '"Your name" <your@email.com>',
        ],

        'work' => [
            'title' => 'Work',
            'shortcut' => 'w',
            'from' => '"Your name" <your@email.com>',
            'to' => '"Your name" <your@work.com>',
        ],

    ],

];
