<?php

return [
    'rapidapi_key' => env('RAPIDAPI_KEY'),

    'featured_users' => [
        [
            'username' => 'diodioglowskin',
            'display_name' => ' Diodio Glow Skin',
            'description' => 'Tech Creator',
            'color' => 'blue',
            'max_videos' => 20, 
        ],
        [
            'username' => 'mamendiayesavon111',
            'display_name' => 'mamendiayesavon',
            'description' => 'Gaming',
            'color' => 'red',
            'max_videos' => 20, 
        ]
    ],

    'default_max_videos_per_user' => 20,

    'videos_per_page' => 12,
    'videos_per_user_per_page' => 4,
    'cache_duration' => 3600, // 1 hour
];