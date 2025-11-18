<?php
// config/tiktok.php

return [
    'rapidapi_key' => env('RAPIDAPI_KEY', ''),
    'featured_users' => [],
    'default_max_videos_per_user' => 20,
    'videos_per_page' => 12,
    'videos_per_user_per_page' => 4,
    'cache_duration' => 3600,
];