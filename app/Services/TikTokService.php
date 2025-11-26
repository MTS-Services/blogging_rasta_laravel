<?php

namespace App\Services;

use App\Models\TikTokVideo;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TikTokService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl = 'https://tiktok-scraper7.p.rapidapi.com/';

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false,
            'http_errors' => false
        ]);
        $this->apiKey = config('tiktok.rapidapi_key');
    }

    /**
     * Get user videos with pagination
     */
    public function getUserVideos($username, $count = 12, $cursor = 0)
    {
        if (empty($this->apiKey)) {
            Log::error("TikTok API key not configured");
            return $this->errorResponse('API key not configured');
        }

        $cacheKey = "tiktok_videos_{$username}_{$count}_{$cursor}";

        // return Cache::remember($cacheKey, 1800, function () use ($username, $count, $cursor) {
        try {
            $response = $this->client->get($this->baseUrl . 'user/posts', [
                'headers' => [
                    'x-rapidapi-host' => 'tiktok-scraper7.p.rapidapi.com',
                    'x-rapidapi-key' => $this->apiKey,
                ],
                'query' => [
                    'unique_id' => $username,
                    'count' => $count,
                    'cursor' => $cursor,
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            if ($statusCode === 403) {
                return $this->errorResponse('API subscription required');
            }

            if ($statusCode !== 200) {
                return $this->errorResponse("API returned status code: {$statusCode}");
            }

            $data = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->errorResponse('Invalid JSON response');
            }

            if (isset($data['code']) && $data['code'] !== 0) {
                return $this->errorResponse($data['msg'] ?? 'API request failed');
            }

            $responseData = $data['data'] ?? [];
            $videos = $responseData['videos'] ?? [];

            foreach ($videos as &$video) {
                $video['_username'] = $username;
            }

            return [
                'success' => true,
                'videos' => $videos,
                'has_more' => $responseData['hasMore'] ?? false,
                'cursor' => $responseData['cursor'] ?? 0,
            ];

        } catch (\Exception $e) {
            Log::error("TikTok API Error: " . $e->getMessage());
            return $this->errorResponse($e->getMessage());
        }
        // });
    }

    /**
     * Get videos from multiple users
     */
    public function getMultipleUsersVideos(array $users)
    {
        $allVideos = [];

        foreach ($users as $user) {
            $result = $this->getUserVideos($user['username'], $user['max_videos'] ?? config('tiktok.default_max_videos_per_user'));

            if ($result['success'] && !empty($result['videos'])) {
                $allVideos = array_merge($allVideos, $result['videos']);
            }
        }

        usort($allVideos, function ($a, $b) {
            return ($b['create_time'] ?? 0) - ($a['create_time'] ?? 0);
        });

        return [
            'success' => true,
            'videos' => $allVideos,
            'total_videos' => count($allVideos),
        ];
    }

    /**
     * Sync videos from API to database
     */
    public function syncVideos(array $users)
    {
        Log::info("Starting TikTok Sync for users: " . implode(', ', array_column($users, 'username')));
        try {
            DB::beginTransaction();

            $result = $this->getMultipleUsersVideos($users);

            if (!$result['success']) {
                throw new \Exception('Failed to fetch videos');
            }

            $syncedCount = 0;
            $updatedCount = 0;

            foreach ($result['videos'] as $video) {
                $videoData = $this->prepareVideoData($video);

                $existingVideo = TikTokVideo::where('aweme_id', $videoData['aweme_id'])->first();

                if ($existingVideo) {
                    $existingVideo->update(
                        [
                            'title' => $videoData['title'],
                            'desc' => $videoData['desc'],
                            'play_url' => $videoData['play_url'],
                            'cover' => $videoData['cover'],
                            'origin_cover' => $videoData['origin_cover'],
                            'play_count' => $videoData['play_count'],
                            'digg_count' => $videoData['digg_count'],
                            'comment_count' => $videoData['comment_count'],
                            'share_count' => $videoData['share_count'],
                            'author_avatar' => $videoData['author_avatar'],
                            'author_avatar_medium' => $videoData['author_avatar_medium'],
                            'author_avatar_larger' => $videoData['author_avatar_larger'],
                            'music_title' => $videoData['music_title'],
                            'video_description' => $videoData['video_description']
                        ]
                    );
                    $updatedCount++;
                } else {
                    TikTokVideo::create($videoData);
                    $syncedCount++;
                }
            }

            DB::commit();

            Log::info("TikTok Sync Complete", [
                'new' => $syncedCount,
                'updated' => $updatedCount
            ]);

            return [
                'success' => true,
                'synced' => $syncedCount,
                'updated' => $updatedCount,
                'total' => $syncedCount + $updatedCount,
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("TikTok Sync Error: " . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Toggle featured status for a video
     */
    public function toggleFeatured($videoId)
    {
        try {
            $video = TikTokVideo::findOrFail($videoId);
            $video->is_featured = !$video->is_featured;
            $video->save();

            return [
                'success' => true,
                'is_featured' => $video->is_featured,
                'message' => $video->is_featured ? 'Video featured' : 'Video unfeatured',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Toggle active status for a video
     */
    public function toggleActive($videoId)
    {
        try {
            $video = TikTokVideo::findOrFail($videoId);
            $video->is_active = !$video->is_active;
            $video->save();

            return [
                'success' => true,
                'is_active' => $video->is_active,
                'message' => $video->is_active ? 'Video activated' : 'Video deactivated',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Prepare video data for database
     */
    private function prepareVideoData($video)
    {
        $author = $video['author'] ?? [];
        $musicInfo = $video['music_info'] ?? [];

        return [
            'aweme_id' => $video['aweme_id'] ?? null,
            'video_id' => $video['video_id'] ?? null,
            'sync_at' => now(),
            'title' => $video['title'] ?? '',
            'desc' => $video['desc'] ?? $video['title'] ?? '',

            // Video URLs - direct from API response
            'play_url' => $video['play'] ?? null,
            'cover' => $video['cover'] ?? null,
            'origin_cover' => $video['origin_cover'] ?? null,
            'dynamic_cover' => $video['ai_dynamic_cover'] ?? null,

            // Statistics - direct counts
            'play_count' => $video['play_count'] ?? 0,
            'digg_count' => $video['digg_count'] ?? 0,
            'comment_count' => $video['comment_count'] ?? 0,
            'share_count' => $video['share_count'] ?? 0,

            // Author info
            'username' => $video['_username'] ?? $author['unique_id'] ?? null,
            'author_name' => $author['unique_id'] ?? null,
            'author_nickname' => $author['nickname'] ?? null,
            'author_avatar' => $author['avatar'] ?? null,
            'author_avatar_medium' => $author['avatar'] ?? null,
            'author_avatar_larger' => $author['avatar'] ?? null,

            // Hashtags & timestamps
            'hashtags' => $this->extractHashtags($video),
            'create_time' => isset($video['create_time']) ? date('Y-m-d H:i:s', $video['create_time']) : now(),

            // Video metadata
            'duration' => $video['duration'] ?? 0,
            'video_format' => 'mp4',

            // Music info
            'music_title' => $musicInfo['title'] ?? null,
            'music_author' => $musicInfo['author'] ?? null,
            'video_description' => $video['desc'] ?? $video['title'] ?? null,

            // Status
            'is_active' => true,
            'is_featured' => false,
        ];
    }

    /**
     * Extract hashtags from video - updated for new API structure
     */
    private function extractHashtags($video)
    {
        $hashtags = [];

        // Check if title has hashtags
        if (isset($video['title']) && !empty($video['title'])) {
            preg_match_all('/#(\w+)/', $video['title'], $matches);
            if (!empty($matches[1])) {
                $hashtags = array_merge($hashtags, $matches[1]);
            }
        }

        // Check if desc has hashtags
        if (isset($video['desc']) && !empty($video['desc'])) {
            preg_match_all('/#(\w+)/', $video['desc'], $matches);
            if (!empty($matches[1])) {
                $hashtags = array_merge($hashtags, $matches[1]);
            }
        }

        // Remove duplicates and return
        return array_unique($hashtags);
    }

    /**
     * Get detailed video info for debugging
     */
    public function getVideoDetails($awemeId)
    {
        $video = TikTokVideo::where('aweme_id', $awemeId)->first();

        if (!$video) {
            return ['success' => false, 'error' => 'Video not found'];
        }

        return [
            'success' => true,
            'video' => $video,
            'urls' => [
                'play_url' => $video->play_url,
                'cover' => $video->cover,
                'origin_cover' => $video->origin_cover,
                'dynamic_cover' => $video->dynamic_cover,
            ],
            'author' => [
                'username' => $video->username,
                'nickname' => $video->author_nickname,
                'avatar' => $video->author_avatar,
            ],
            'stats' => [
                'plays' => $video->formatted_play_count,
                'likes' => $video->formatted_digg_count,
                'comments' => $video->formatted_comment_count,
            ],
        ];
    }

    /**
     * Format numbers for display
     */
    public function formatNumber($number)
    {
        if (!is_numeric($number)) {
            return '0';
        }

        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }

        return number_format($number);
    }

    /**
     * Clear cache
     */
    public function clearCache($username = null)
    {
        if ($username) {
            Cache::forget("tiktok_videos_{$username}");
        } else {
            Cache::flush();
        }
    }

    /**
     * Error response
     */
    private function errorResponse($message)
    {
        return [
            'success' => false,
            'error' => $message,
            'videos' => [],
        ];
    }
}
