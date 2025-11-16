<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            [
                'title'             => 'Getting Started With Our Platform',
                'slug'              => Str::slug('Getting Started With Our Platform'),
                'status'            => 'published',
                'file'              => 'uploads/blogs/sample1.jpg',
                'description'       => 'This is a sample blog description for getting started.',
                'meta_title'        => 'Getting Started Guide',
                'meta_description'  => 'Learn how to get started with our system.',
                'meta_keywords'     => ['guide', 'start', 'platform'],
            ],
            [
                'title'             => 'Top Features You Should Know',
                'slug'              => Str::slug('Top Features You Should Know'),
                'status'            => 'unpublished',
                'file'              => 'uploads/blogs/sample2.jpg',
                'description'       => 'Brief explanation of the top features.',
                'meta_title'        => 'Platform Features Overview',
                'meta_description'  => 'Explore the key features available on our platform.',
                'meta_keywords'     => ['features', 'overview', 'platform'],
            ],
            [
                'title'             => 'How to Use the Video Upload System',
                'slug'              => Str::slug('How to Use the Video Upload System'),
                'status'            => 'published',
                'file'              => 'uploads/blogs/tutorial-video.mp4',
                'description'       => 'Step-by-step video upload tutorial.',
                'meta_title'        => 'Video Upload Tutorial',
                'meta_description'  => 'Learn how to upload videos easily.',
                'meta_keywords'     => ['video', 'upload', 'tutorial'],
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
}
