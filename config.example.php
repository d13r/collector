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
            'return' => 'your@email.com',
            'from' => '"Your name" <your@email.com>',
            'replyto' => ['"Your name" <your@email.com>'],
            'to' => ['"Your name" <your@email.com>'],
        ],

        'work' => [
            'title' => 'Work',
            'shortcut' => 'w',
            'return' => 'your@email.com',
            'from' => '"Your name" <your@email.com>',
            'replyto' => ['"Your name" <your@work.com>'],
            'to' => ['"Your name" <your@work.com>'],
        ],

        'both' => [
            'title' => 'Both',
            'shortcut' => 'b',
            'return' => 'your@email.com',
            'from' => '"Your name" <your@email.com>',
            'replyto' => ['"Your name" <your@email.com>', '"Your name" <your@work.com>'],
            'to' => ['"Your name" <your@email.com>', '"Your name" <your@work.com>'],
        ],

    ],

    // AWS SES
    'aws' => [
        'region' => 'eu-west-2',
        'key' => '',
        'secret' => '',
    ],

];
