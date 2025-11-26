<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\AuditColumnsTrait;

return new class extends Migration {
    use AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('about_cms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->index()->default(0);
            $table->string('contact_email')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_fr')->nullable();
            $table->longText('about_us_en')->nullable();
            $table->longText('about_us_fr')->nullable();
            $table->string('banner_video')->nullable();
            $table->string('mission_title_en')->nullable();
            $table->string('mission_title_fr')->nullable();
            $table->longText('mission_en')->nullable();
            $table->longText('mission_fr')->nullable();

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
        Schema::dropIfExists('about_cms');
    }
};
