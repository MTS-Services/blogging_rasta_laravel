<?php

return [
    'rapidapi_key' => env('RAPIDAPI_KEY'),

    'featured_users' => [
        [
            'username' => 'wasif1ahmed',
            'display_name' => 'Wasif Ahmed',
            'description' => 'Tech Creator',
            'color' => 'blue',
            'max_videos' => 26, 
        ],
        [
            'username' => 'wasifahmed996',
            'display_name' => 'Wasif Ahmed',
            'description' => 'Gaming',
            'color' => 'red',
            'max_videos' => 12, 
        ],
        [
            'username' => 'aksumonn',
            'display_name' => 'Sumon Akash',
            'description' => 'Gaming',
            'color' => 'green',
            'max_videos' => 3, 
        ],
    ],

    // Default limit if not specified per user
    'default_max_videos_per_user' => 20,

    'videos_per_page' => 12,
    'videos_per_user_per_page' => 4,
    'cache_duration' => 3600, // 1 hour
];