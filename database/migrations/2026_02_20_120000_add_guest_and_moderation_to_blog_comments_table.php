<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds guest comment support and moderation (is_approved) without breaking existing data.
     */
    public function up(): void
    {
        Schema::table('blog_comments', function (Blueprint $table) {
            $table->string('guest_name', 255)->nullable()->after('user_id');
            $table->string('guest_email', 255)->nullable()->after('guest_name');
            $table->boolean('is_approved')->default(false)->after('body');
        });

        Schema::table('blog_comments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE blog_comments MODIFY user_id BIGINT UNSIGNED NULL');
        } else {
            Schema::table('blog_comments', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->change();
            });
        }

        Schema::table('blog_comments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Existing comments (from logged-in users) are treated as approved so behaviour is unchanged
        DB::table('blog_comments')->whereNotNull('user_id')->update(['is_approved' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_comments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE blog_comments MODIFY user_id BIGINT UNSIGNED NOT NULL');
        } else {
            Schema::table('blog_comments', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable(false)->change();
            });
        }

        Schema::table('blog_comments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('blog_comments', function (Blueprint $table) {
            $table->dropColumn(['guest_name', 'guest_email', 'is_approved']);
        });
    }
};
