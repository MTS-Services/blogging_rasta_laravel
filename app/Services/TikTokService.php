<?php

namespace App\Services;

use App\Models\ApplicationSetting;
use App\Models\TikTokVideo;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TikTokService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl = 'https://tiktok-scraper7.p.rapidapi.com/';

    protected $thumbnailService;
    protected $videoService;



    // Update your __construct method to inject ThumbnailDownloadService:
    public function __construct(
        ThumbnailDownloadService $thumbnailService,
        VideoDownloadService $videoService // NEW
    ) {
        $this->thumbnailService = $thumbnailService;
        $this->videoService = $videoService; // NEW

        $this->client = new Client([
            'timeout' => 60,
            'connect_timeout' => 10,
            'verify' => true,
            'http_errors' => false
        ]);

        $this->apiKey = ApplicationSetting::where('key', ApplicationSetting::RAPIDAPI_KEY)
            ->pluck('value')
            ->first();
    }


    private function isMeaningfulTitle($title)
    {
        if (empty($title)) {
            return false;
        }

        // Remove emojis and special characters, keep only letters and numbers
        $cleanTitle = preg_replace('/[^\p{L}\p{N}\s]/u', '', $title);
        $cleanTitle = trim($cleanTitle);

        // If after removing emojis/special chars, we have less than 3 characters, it's not meaningful
        return strlen($cleanTitle) >= 3;
    }

    /**
     * Extract emojis from text
     */
    private function extractEmojis($text)
    {
        if (empty($text)) {
            return '';
        }

        // Match emojis (comprehensive Unicode ranges)
        preg_match_all('/[\x{1F300}-\x{1F9FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{1F600}-\x{1F64F}\x{1F680}-\x{1F6FF}\x{1F1E0}-\x{1F1FF}]/u', $text, $matches);

        if (!empty($matches[0])) {
            // Keep max 3 emojis
            return implode('', array_slice($matches[0], 0, 3));
        }

        return '';
    }




    public function getUserVideos($username, $count = 12, $cursor = 0)
    {
        Log::info("getUserVideos called", [
            'username' => $username,
            'count' => $count,
            'cursor' => $cursor,
            'api_key_set' => !empty($this->apiKey),
            'api_key_length' => $this->apiKey ? strlen($this->apiKey) : 0
        ]);

        if (empty($this->apiKey)) {
            Log::error("TikTok API key not configured");
            return $this->errorResponse('API key not configured');
        }

        try {
            Log::info("Making API request to: " . $this->baseUrl . 'user/posts');

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

            Log::info("API Response received", [
                'status_code' => $statusCode,
                'body_length' => strlen($body),
                'body_preview' => substr($body, 0, 200)
            ]);

            if ($statusCode === 403) {
                Log::error("API returned 403 - subscription required");
                return $this->errorResponse('API subscription required');
            }

            if ($statusCode !== 200) {
                Log::error("API returned non-200 status", ['status' => $statusCode, 'body' => $body]);
                return $this->errorResponse("API returned status code: {$statusCode}");
            }

            $data = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error("JSON decode error", ['error' => json_last_error_msg(), 'body' => $body]);
                return $this->errorResponse('Invalid JSON response');
            }

            Log::info("API data decoded", [
                'has_data' => isset($data['data']),
                'code' => $data['code'] ?? null,
                'msg' => $data['msg'] ?? null
            ]);

            if (isset($data['code']) && $data['code'] !== 0) {
                Log::error("API returned error code", ['code' => $data['code'], 'msg' => $data['msg'] ?? '']);
                return $this->errorResponse($data['msg'] ?? 'API request failed');
            }

            $responseData = $data['data'] ?? [];
            $videos = $responseData['videos'] ?? [];

            Log::info("Videos extracted", ['count' => count($videos)]);

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
            Log::error("TikTok API Exception", [
                'message' => $e->getMessage(),
                'class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->errorResponse($e->getMessage());
        }
    }


    public function getMultipleUsersVideos($users)
    {
        $allVideos = [];
        $errors = [];

        foreach ($users as $user) {
            Log::info("Fetching videos for user: " . $user['username']);

            $result = $this->getUserVideos(
                $user['username'],
                $user['max_videos']
            );

            Log::info("Result for {$user['username']}", [
                'success' => $result['success'],
                'video_count' => count($result['videos'] ?? []),
                'error' => $result['error'] ?? null
            ]);

            if (!$result['success']) {
                $errors[] = [
                    'username' => $user['username'],
                    'error' => $result['error'] ?? 'Unknown error'
                ];
                Log::error("Failed to fetch videos for {$user['username']}", [
                    'error' => $result['error'] ?? 'Unknown error'
                ]);
            }

            if ($result['success'] && !empty($result['videos'])) {
                $allVideos = array_merge($allVideos, $result['videos']);
            }
        }

        usort($allVideos, function ($a, $b) {
            return ($b['create_time'] ?? 0) - ($a['create_time'] ?? 0);
        });

        // Log final result
        Log::info("getMultipleUsersVideos completed", [
            'total_videos' => count($allVideos),
            'errors' => $errors
        ]);

        return [
            'success' => empty($errors) || !empty($allVideos),
            'videos' => $allVideos,
            'total_videos' => count($allVideos),
            'errors' => $errors,
        ];
    }

    /**
     * Sync videos from API to database
     */
    public function syncVideos($users)
    {
        Log::info("Starting TikTok Sync for users");

        $this->clearCache();
        try {
            DB::beginTransaction();

            $result = $this->getMultipleUsersVideos($users);

            Log::info("API Result", ['success' => $result['success'], 'video_count' => count($result['videos'] ?? [])]);

            if (!$result['success']) {
                throw new \Exception('Failed to fetch videos');
            }

            $syncedCount = 0;
            $updatedCount = 0;

            foreach ($result['videos'] as $video) {
                $existingVideo = TikTokVideo::where('video_id', $video['video_id'])->first();
                $videoData = $this->prepareVideoData($video, $existingVideo);


                if ($existingVideo) {
                    $existingVideo->update([
                        'title' => $videoData['title'],
                        'desc' => $videoData['desc'],
                        'play_url' => $videoData['play_url'],
                        'local_video_url' => $videoData['local_video_url'], // NEW
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
                        'video_description' => $videoData['video_description'],
                        'thumbnail_url' => $videoData['thumbnail_url']
                    ]);
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


    public function updateEmptyVideos()
    {
        try {
            Log::info("Starting update of empty videos...");

            // Find videos with empty data OR only emoji/special characters
            $videos = TikTokVideo::all();

            $videosToUpdate = $videos->filter(function ($video) {
                return !$this->isMeaningfulTitle($video->title) ||
                    !$this->isMeaningfulTitle($video->desc) ||
                    empty($video->slug);
            });

            Log::info("Found videos to update", ['count' => $videosToUpdate->count()]);

            $updatedCount = 0;
            $errors = [];

            foreach ($videosToUpdate as $video) {
                $awemeId = $video->aweme_id;
                $videoId = $video->video_id;

                try {
                    $updates = [];
                    $changed = false;

                    $username = $video->username ?? 'creator';

                    // Generate title if not meaningful
                    if (!$this->isMeaningfulTitle($video->title)) {
                        $updates['title'] = $this->generateTitleWithCategory($video->title, $username, $video->toArray());
                        $changed = true;
                    }

                    // Generate description if not meaningful
                    if (!$this->isMeaningfulTitle($video->desc)) {
                        $title = $updates['title'] ?? $video->title;
                        $category = $this->detectCategory($video->toArray());
                        $updates['desc'] = $this->generateDescriptionWithCategory($video->desc, $username, $category);
                        $updates['video_description'] = $updates['desc'];
                        $changed = true;
                    }

                    // Generate slug if empty or needs update
                    if (empty($video->slug) || $changed) {
                        $title = $updates['title'] ?? $video->title;
                        $updates['slug'] = $this->generateSlug($title, $videoId, $username, $video->toArray());
                        $changed = true;
                    }

                    // Update video if changes were made
                    if ($changed) {
                        $video->update($updates);
                        $updatedCount++;

                        Log::info("Updated video", [
                            'video_id' => $videoId,
                            'old_title' => $video->title,
                            'new_title' => $updates['title'] ?? null,
                        ]);
                    }

                } catch (\Exception $e) {
                    $errors[] = [
                        'video_id' => $videoId,
                        'error' => $e->getMessage()
                    ];
                    Log::error("Failed to update video", [
                        'video_id' => $videoId,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            Log::info("Update completed", [
                'updated' => $updatedCount,
                'errors' => count($errors)
            ]);

            return [
                'success' => true,
                'message' => "Successfully updated {$updatedCount} videos",
                'updated' => $updatedCount,
                'total_found' => $videosToUpdate->count(),
                'errors' => $errors
            ];

        } catch (\Exception $e) {
            Log::error("Update empty videos failed", [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    private function getEmojiDescription($text)
    {
        if (empty($text)) {
            return '';
        }

        // Map common emojis to text for slug
        $emojiMap = [
            '❤️' => 'love',
            '😍' => 'love',
            '🔥' => 'fire',
            '💯' => '100',
            '😂' => 'lol',
            '🎵' => 'music',
            '🎶' => 'music',
            '💃' => 'dance',
            '🕺' => 'dance',
            '⚽' => 'football',
            '🏀' => 'basketball',
            '🎮' => 'gaming',
            '📱' => 'phone',
            '💰' => 'money',
            '👑' => 'king',
            '💪' => 'strong',
            '🙏' => 'pray',
            '✨' => 'sparkle',
            '🌟' => 'star',
            '👍' => 'like',
            '👏' => 'clap',
        ];

        $emojiNames = [];

        foreach ($emojiMap as $emoji => $name) {
            if (mb_strpos($text, $emoji) !== false) {
                $emojiNames[] = $name;

                // Only take first 2 emojis
                if (count($emojiNames) >= 2) {
                    break;
                }
            }
        }

        return !empty($emojiNames) ? implode('-', $emojiNames) : '';
    }

    public function generateSlug($title, $videoId, $username = 'creator', $videoData = [])
    {
        // 1. Build raw slug
        if ($this->isMeaningfulTitle($title)) {
            $rawSlug = Str::slug($title);
        } else {
            $category = $this->detectCategory($videoData);
            $emojiText = $this->getEmojiDescription($title);

            if (!empty($emojiText)) {
                $rawSlug = 'video-tiktok-' . Str::slug($username) . '-' . $emojiText . '-' . Str::slug($category) . '-diodioglow';
            } else {
                $rawSlug = 'video-tiktok-' . Str::slug($username) . '-' . Str::slug($category) . '-diodioglow';
            }
        }

        // 2. Limit raw slug to max 70 chars
        $slug = substr($rawSlug, 0, 70);
        $slug = rtrim($slug, '-');

        // 3. FAST uniqueness check — count similar slugs
        $likePattern = $slug . '%';

        $count = TikTokVideo::where('slug', 'LIKE', $likePattern)->count();

        if ($count === 0) {
            return $slug; // Slug is unique
        }

        // 4. Add suffix without exceeding 70 chars (videoId + count)
        $suffix = '-' . $videoId . '-' . $count;
        $maxBaseLength = 70 - strlen($suffix);

        $baseSlug = substr($slug, 0, $maxBaseLength);
        $baseSlug = rtrim($baseSlug, '-');

        return $baseSlug . $suffix;
    }




    private function prepareVideoData($video, $existingVideo = null)
    {
        $author = $video['author'] ?? [];
        $musicInfo = $video['music_info'] ?? [];
        $awemeId = $video['aweme_id'];
        $videoId = $video['video_id'];

        // Get original title/desc from TikTok
        $originalTitle = trim($video['title'] ?? '');
        $originalDesc = trim($video['desc'] ?? '');

        // Get username for fallback
        $username = $video['_username'] ?? $author['unique_id'] ?? 'creator';

        // Check if title is meaningful (not empty, not just emojis)
        if (!$existingVideo && !$this->isMeaningfulTitle($originalTitle)) {
            $finalTitle = $this->generateTitleWithCategory($originalTitle, $username, $video);
        } else {
            $finalTitle = $originalTitle;
        }

        // Check if description is meaningful
        if (!$existingVideo && !$this->isMeaningfulTitle($originalDesc)) {
            // Description is empty OR only emojis - generate meaningful description
            $category = $this->detectCategory($video);
            $finalDesc = $this->generateDescriptionWithCategory($originalDesc, $username, $category);
        } else {
            $finalDesc = $originalDesc;
        }

        // Generate slug
        if (!$existingVideo) {
            $slug = $this->generateSlug($finalTitle, $videoId, $username, $video);
        } else {
            $slug = $existingVideo->slug;
        }

        // Original TikTok CDN URLs
        $originCover = $video['origin_cover'] ?? null;
        $cover = $video['cover'] ?? null;
        $dynamicCover = $video['ai_dynamic_cover'] ?? null;
        $playUrl = $video['play'] ?? null; // TikTok CDN video URL

        // ========================================
        // NEW: Download and store thumbnail locally
        // ========================================
        $localThumbnail = null;
        $localVideoUrl = null;
        if (!$existingVideo || (isset($existingVideo->thumbnail_url) && empty($existingVideo?->thumbnail_url))) {
            if ($originCover) {
                $localThumbnail = $this->thumbnailService->downloadAndStore($originCover, $videoId);
            }

            if (!$localThumbnail && $cover) {
                $localThumbnail = $this->thumbnailService->downloadAndStore($cover, $videoId);
            }
        } else {
            $localThumbnail = $existingVideo->thumbnail_url;
        }

        // ========================================
        // NEW: Download and store video locally
        // ========================================
        $localVideoUrl = null;

        if (!$existingVideo || (isset($existingVideo->local_video_url) && empty($existingVideo?->local_video_url))) {
            // New video OR existing video without local storage
            if ($playUrl) {
                Log::info('Downloading video for storage', [
                    'video_id' => $videoId,
                    'username' => $username
                ]);

                // Download with retry mechanism (3 attempts)
                $localVideoUrl = $this->videoService->downloadAndStore(
                    $playUrl,
                    $videoId,
                    $username,
                );

                if ($localVideoUrl) {
                    Log::info('Video downloaded successfully', [
                        'video_id' => $videoId,
                        'local_url' => $localVideoUrl
                    ]);
                } else {
                    Log::error('Failed to download video after retries', [
                        'video_id' => $videoId,
                        'cdn_url' => substr($playUrl, 0, 100)
                    ]);
                }
            }
        } else {
            // Use existing local video
            $localVideoUrl = $existingVideo->local_video_url;

            // Verify existing video still exists
            if (!$this->videoService->videoExists($localVideoUrl)) {
                Log::warning('Local video missing, re-downloading', [
                    'video_id' => $videoId,
                    'old_path' => $localVideoUrl
                ]);

                // Re-download if missing
                if ($playUrl) {
                    $localVideoUrl = $this->videoService->downloadAndStore(
                        $playUrl,
                        $videoId,
                        $username,
                    );
                }
            }
        }

        return [
            'aweme_id' => $awemeId,
            'video_id' => $videoId,
            'sync_at' => now(),
            'title' => $finalTitle,
            'slug' => $slug,
            'desc' => $finalDesc,

            // Store both CDN URL (reference) and local URL (actual playback)
            'play_url' => $playUrl, // Keep original CDN URL as reference
            'local_video_url' => $localVideoUrl, // NEW: Local storage URL for playback

            'cover' => $cover,
            'origin_cover' => $originCover,
            'dynamic_cover' => $dynamicCover,
            'thumbnail_url' => $localThumbnail,

            'play_count' => $video['play_count'] ?? 0,
            'digg_count' => $video['digg_count'] ?? 0,
            'comment_count' => $video['comment_count'] ?? 0,
            'share_count' => $video['share_count'] ?? 0,

            'username' => $username,
            'author_name' => $author['unique_id'] ?? null,
            'author_nickname' => $author['nickname'] ?? null,
            'author_avatar' => $author['avatar'] ?? null,
            'author_avatar_medium' => $author['avatar'] ?? null,
            'author_avatar_larger' => $author['avatar'] ?? null,

            'hashtags' => $this->extractHashtags($video),
            'create_time' => isset($video['create_time'])
                ? date('Y-m-d H:i:s', $video['create_time'])
                : now(),

            'duration' => $video['duration'] ?? 0,
            'video_format' => 'mp4',

            'music_title' => $musicInfo['title'] ?? null,
            'music_author' => $musicInfo['author'] ?? null,
            'video_description' => $finalDesc,

            'is_active' => true,
            'is_featured' => false,
        ];
    }


    /**
     * Auto-generate title ONLY when original is empty
     */
    private function generateAutoTitle($username)
    {
        return "Vidéo TikTok virale de @{$username} | DiodioGlow";
    }

    /**
     * Auto-generate description ONLY when original is empty
     */
    private function generateAutoDescription($username, $title)
    {
        return "Découvrez cette vidéo TikTok captivante de @{$username}. " .
            "Suivez les tendances virales du Sénégal avec DiodioGlow - " .
            "Votre source #1 pour le meilleur contenu TikTok, buzz, musique et actualités.";
    }

    // ============================================
    // STEP 5: Optional - Add Category Detection
    // ============================================

    /**
     * Detect video category from hashtags or content (optional enhancement)
     */
    private function detectCategory($video)
    {
        if (empty($video)) {
            return 'tendance';
        }

        // Get hashtags
        $hashtags = [];
        if (isset($video['hashtags'])) {
            $hashtags = is_array($video['hashtags']) ? $video['hashtags'] : [];
        } elseif (is_object($video) && isset($video->hashtags)) {
            $hashtags = is_array($video->hashtags) ? $video->hashtags : json_decode($video->hashtags, true) ?? [];
        }

        $hashtagString = strtolower(implode(' ', $hashtags));

        // Get title and description
        $title = '';
        $desc = '';

        if (is_array($video)) {
            $title = strtolower($video['title'] ?? '');
            $desc = strtolower($video['desc'] ?? '');
        } elseif (is_object($video)) {
            $title = strtolower($video->title ?? '');
            $desc = strtolower($video->desc ?? '');
        }

        $content = $hashtagString . ' ' . $title . ' ' . $desc;

        // Define category keywords (French and English)
        $categories = [
            'musique' => ['music', 'song', 'musique', 'beat', 'rap', 'dance', 'danse', 'chanson', 'audio', 'sound'],
            'buzz' => ['viral', 'trending', 'buzz', 'hot', 'popular', 'populaire', 'tendance', 'trend'],
            'politique' => ['politique', 'politics', 'senegal', 'government', 'gouvernement', 'election', 'president'],
            'humour' => ['funny', 'comedy', 'humour', 'lol', 'meme', 'drole', 'rire', 'blague', 'laugh'],
            'sport' => ['sport', 'football', 'basketball', 'fitness', 'gym', 'match', 'goal', 'training'],
            'mode' => ['fashion', 'style', 'mode', 'outfit', 'look', 'vetement', 'clothes', 'drip'],
            'cuisine' => ['food', 'cooking', 'recette', 'cuisine', 'recipe', 'dish', 'eat', 'restaurant'],
            'beaute' => ['beauty', 'makeup', 'beaute', 'maquillage', 'skincare', 'hair', 'cheveux'],
            'education' => ['learn', 'education', 'tutorial', 'tuto', 'apprendre', 'study', 'school'],
            'voyage' => ['travel', 'voyage', 'trip', 'vacation', 'destination', 'tourisme'],
        ];

        // Check each category
        foreach ($categories as $category => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($content, $keyword) !== false) {
                    return $category;
                }
            }
        }

        // Default category
        return 'tendance';
    }

    /**
     * Enhanced title generation with category (optional)
     */
    private function generateTitleWithCategory($originalTitle, $username, $video = [])
    {
        // If title has meaningful text (not just emojis), use it
        if ($this->isMeaningfulTitle($originalTitle)) {
            return trim($originalTitle);
        }

        // Title is empty OR only emojis/special characters
        // Extract emojis from original title if any
        $emojis = $this->extractEmojis($originalTitle);

        // Detect category
        $category = $this->detectCategory($video);

        // Build meaningful title with emojis
        if (!empty($emojis)) {
            // Format: Vidéo TikTok 😍🔥 de @username – musique | DiodioGlow
            return "Vidéo TikTok {$emojis} de @{$username} – {$category} | DiodioGlow";
        } else {
            // No emojis, just generate standard title
            return "Vidéo TikTok virale de @{$username} – {$category} | DiodioGlow";
        }
    }



    /**
     * Enhanced description with category (optional)
     */
    private function generateDescriptionWithCategory($originalDesc, $username, $category)
    {
        // If description has meaningful text, use it
        if ($this->isMeaningfulTitle($originalDesc)) {
            return trim($originalDesc);
        }

        // Description is empty OR only emojis
        // Extract emojis if any
        $emojis = $this->extractEmojis($originalDesc);

        $baseDescription = "Découvrez cette vidéo TikTok captivante de @{$username}";

        if (!empty($emojis)) {
            $baseDescription .= " {$emojis}";
        }

        $baseDescription .= " dans la catégorie {$category}. " .
            "Suivez les tendances virales du Sénégal avec DiodioGlow - " .
            "Votre source #1 pour le meilleur contenu TikTok, buzz, musique et actualités.";

        return $baseDescription;
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
    public function getVideoDetails($videoId)
    {
        $video = TikTokVideo::where('video_id', $videoId)->first();

        if (!$video) {
            return ['success' => false, 'error' => 'Video not found'];
        }

        return [
            'success' => true,
            'video' => $video,
            'urls' => [
                'play_url' => $video->play_url,
                'thumbnail_url' => $video->thumbnail_url,
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


    public function cleanupUnusedLocalVideos(bool $debug = false): array
    {
        $folderPath = storage_path('app/public/videos/tiktok');

        if (!File::exists($folderPath)) {
            Log::warning("TikTok cleanup: folder not found => {$folderPath}");
            return [
                'success' => true,
                'unused_count' => 0,
                'deleted' => 0
            ];
        }

        $allFiles = collect(File::files($folderPath))
            ->map(fn($file) => $file->getFilename())
            ->toArray();

        $usedFiles = TikTokVideo::pluck('local_video_url')
            ->filter()
            ->map(fn($path) => basename($path))
            ->unique()
            ->toArray();

        $unusedFiles = array_diff($allFiles, $usedFiles);

        $deletedCount = 0;

        foreach ($unusedFiles as $filename) {
            $filePath = $folderPath . '/' . $filename;

            if (!File::exists($filePath)) {
                continue;
            }

            if ($debug) {
                Log::info("TikTok cleanup (debug): Would delete => {$filename}");
            }

            Storage::disk('public')->delete('videos/tiktok/' . $filename);
            $deletedCount++;

            Log::info("TikTok cleanup: Deleted => {$filename}");
        }

        return [
            'success' => true,
            'unused_count' => count($unusedFiles),
            'deleted' => $deletedCount
        ];
    }

}
