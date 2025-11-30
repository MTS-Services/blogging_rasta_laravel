<?php

use App\Enums\UserCategoryStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\AuditColumnsTrait;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    use AuditColumnsTrait;
    public function up(): void
    {
        Schema::create('user_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0);
            $table->string('title');
            $table->string('status')->default(UserCategoryStatus::ACTIVE->value);


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
        Schema::dropIfExists('user_categories');
    }
};
