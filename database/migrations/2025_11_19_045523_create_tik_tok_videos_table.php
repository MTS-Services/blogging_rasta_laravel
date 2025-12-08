<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tik_tok_videos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0);
            // Video Identification
            $table->string('aweme_id')->unique()->index();
            $table->string('video_id')->nullable();
            $table->timestamp('sync_at')->nullable()->index();

            // Video Content
            $table->longText('title')->nullable();
            $table->longText('slug')->nullable()->index();
            $table->longText('desc')->nullable();
            $table->longText('play_url')->nullable();
            $table->longText('cover')->nullable();
            $table->longText('origin_cover')->nullable();
            $table->longText('dynamic_cover')->nullable();
            $table->longText('thumbnail_url')->nullable();
            $table->longText('local_video_url')->nullable();

            // Statistics
            $table->bigInteger('play_count')->default(0);
            $table->bigInteger('digg_count')->default(0);
            $table->bigInteger('comment_count')->default(0);
            $table->bigInteger('share_count')->default(0);

            // Author Information
            $table->string('username')->index();
            $table->string('author_name')->nullable();
            $table->string('author_nickname')->nullable();
            $table->longText('author_avatar')->nullable();
            $table->longText('author_avatar_medium')->nullable();
            $table->longText('author_avatar_larger')->nullable();

            // Hashtags (stored as JSON array)
            $table->json('hashtags')->nullable();

            // Video Metadata
            $table->timestamp('create_time')->nullable();
            $table->integer('duration')->nullable();
            $table->string('video_format')->nullable();

            // Featured/Display Control
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_active')->default(false)->index();

            // Additional Fields
            $table->string('music_title')->nullable();
            $table->string('music_author')->nullable();
            $table->longText('video_description')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tik_tok_videos');
    }
};
