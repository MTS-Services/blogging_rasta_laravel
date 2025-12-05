<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\TikTokVideo;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SitemapService
{

    protected string $sitemapPath;

    public function __construct()
    {
        $this->sitemapPath = public_path('sitemap.xml');
    }
    public function generate(): Sitemap
    {
        $sitemap = Sitemap::create();

        // Static pages
        $sitemap->add(Url::create('/')
            ->setLastModificationDate(Carbon::now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(1.0));

        $sitemap->add(Url::create('/terms_conditions'));
        $sitemap->add(Url::create('/privacy_policy'));
        $sitemap->add(Url::create('/blog'));
        $sitemap->add(Url::create('/contact'));
        $sitemap->add(Url::create('/forum'));
        $sitemap->add(Url::create('/single-forum'));

        // Example: Dynamic routes from posts
        $blogs = Blog::published()->get();
        foreach ($blogs as $blog) {
            $sitemap->add(Url::create(route('blog.details', $blog->slug))
                ->setLastModificationDate($blog->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8));
        }
        $videos = TikTokVideo::active()->get();
        foreach ($videos as $video) {
            $sitemap->add(Url::create(route('video.details', $video->video_id))
                ->setLastModificationDate($video->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8));
        }

        // Add other models similarly...
        $sitemap->writeToFile(public_path('sitemap.xml'));

        return $sitemap;
    }

    public function addNew($route, $updated_at): void
    {
        try {
            $sitemap = File::exists($this->sitemapPath)
                ? Sitemap::load($this->sitemapPath)
                : Sitemap::create();

            $sitemap->add(
                Url::create($route)
                    ->setLastModificationDate(Carbon::parse($updated_at))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );

            $sitemap->writeToFile($this->sitemapPath);
        } catch (\Exception $e) {
            Log::info("Sitemap Add Error: " . $e->getMessage());
        }
    }
}
