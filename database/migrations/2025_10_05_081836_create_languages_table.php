<?php

use App\Enums\LanguageStatus;
use App\Enums\LanguageDirection;
use App\Traits\AuditColumnsTrait;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    use AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->index()->default(0);
            $table->string('locale')->unique()->comment('en, es, fr, bn');
            $table->string('name')->unique()->comment('English, Spanish, France');
            $table->string('native_name')->nullabl()->comment('English, Español');
            $table->string('flag_icon');
            $table->string('status')->index()->default(LanguageStatus::ACTIVE->value);
            $table->boolean('is_active')->default(false);
            $table->string('direction')->index()->default(LanguageDirection::LTR->value);

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
        Schema::dropIfExists('languages');
    }
};
