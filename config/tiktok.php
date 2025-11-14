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
            'username' => 'sahedulh4k',
            'display_name' => 'Sahedul Haq',
            'description' => 'Gaming',
            'color' => 'red',
        ],
        [
            'username' => 'bdtechtuber',
            'display_name' => 'BD Tech',
            'description' => 'Technology',
            'color' => 'green',
        ],
    ],

    'videos_per_user' => 12,
    'cache_duration' => 3600, // 1 hour
];