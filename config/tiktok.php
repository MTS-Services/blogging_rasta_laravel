<?php
return [
    'rapidapi_key' => env('RAPIDAPI_KEY'),

    'featured_users' => [
        [
            'username' => 'wasif1ahmed',
            'display_name' => 'Wasif Ahmed',
            'description' => 'Tech Creator',
            'color' => 'blue',
        ],
        [
            'username' => 'wasifahmed996',
            'display_name' => 'Wasif Ahmed',
            'description' => 'Gaming',
            'color' => 'red',
        ]
    ],

    'videos_per_user' => 12,
    'cache_duration' => 3600, // 1 hour
];