<?php

return [

    // Username
    'username' => '',

    // Password hash (run bin/generate-password-hash)
    'password-hash' => '',

    // Targets
    'targets' => [

        'home' => [
            'title' => 'Home',
            'shortcut' => 'h',
            'return' => 'your@email.com',
            'from' => ['your@email.com', 'Your name'],
            'replyto' => [
                ['your@email.com', 'Your name'],
            ],
            'to' => [
                ['your@email.com', 'Your name'],
            ],
            'color' => '#00f',
        ],

        'work' => [
            'title' => 'Work',
            'shortcut' => 'w',
            'return' => 'your@email.com',
            'from' => ['your@email.com', 'Your name'],
            'replyto' => [
                ['Your name', 'your@work.com'],
            ],
            'to' => [
                ['Your name', 'your@work.com'],
            ],
            'color' => '#080',
        ],

        'both' => [
            'title' => 'Both',
            'shortcut' => 'b',
            'return' => 'your@email.com',
            'from' => ['your@email.com', 'Your name'],
            'replyto' => [
                ['your@email.com', 'Your name'],
                ['Your name', 'your@work.com'],
            ],
            'to' => [
                ['your@email.com', 'Your name'],
                ['Your name', 'your@work.com'],
            ],
            'color' => '#c00',
        ],

    ],

];
