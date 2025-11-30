<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\AuditColumnsTrait;
use App\Enums\TikTokUserStatus;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    use AuditColumnsTrait;
    public function up(): void
    {
        Schema::create('tik_tok_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0);
            $table->unsignedBigInteger('user_category_id');
            $table->string('name');
            $table->string('username');
            $table->bigInteger('max_videos')->default(0);
            $table->string('status')->default(TikTokUserStatus::ACTIVE->value);
            $table->foreign('user_category_id')->references('id')->on('user_categories')->onDelete('cascade');


            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiktok_users');
    }
};
