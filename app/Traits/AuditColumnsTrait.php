<?php

namespace App\Traits;

use Illuminate\Database\Schema\Blueprint;

trait AuditColumnsTrait
{
    public function addAdminAuditColumns(Blueprint $table): void
    {
        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('updated_by')->nullable();
        $table->unsignedBigInteger('deleted_by')->nullable();
        $table->unsignedBigInteger('restored_by')->nullable();
        $table->timestamp('restored_at')->nullable();

        $table->foreign('created_by')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('updated_by')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('deleted_by')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('restored_by')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');

        $table->index('created_by');
        $table->index('updated_by');
        $table->index('deleted_by');
        $table->index('restored_by');
    }
    public function dropAdminAuditColumns(Blueprint $table): void
    {
        $table->dropForeign(['created_by']);
        $table->dropForeign(['updated_by']);
        $table->dropForeign(['deleted_by']);
        $table->dropForeign(['restored_by']);

        $table->dropIndex(['created_by']);
        $table->dropIndex(['updated_by']);
        $table->dropIndex(['deleted_by']);
        $table->dropIndex(['restored_by']);

        $table->dropColumn('created_by');
        $table->dropColumn('updated_by');
        $table->dropColumn('deleted_by');
        $table->dropColumn('restored_by');
        $table->dropColumn('restored_at');
    }


    public function addMorphedAuditColumns(Blueprint $table): void
    {
        $table->unsignedBigInteger('creater_id')->nullable();
        $table->string('creater_type')->nullable();
        $table->unsignedBigInteger('updater_id')->nullable();
        $table->string('updater_type')->nullable();
        $table->unsignedBigInteger('deleter_id')->nullable();
        $table->string('deleter_type')->nullable();
        $table->unsignedBigInteger('restorer_id')->nullable();
        $table->string('restorer_type')->nullable();

        $table->timestamp('restored_at')->nullable();

        $table->index(['creater_id', 'creater_type']);
        $table->index(['updater_id', 'updater_type']);
        $table->index(['deleter_id', 'deleter_type']);
        $table->index(['restorer_id', 'restorer_type']);
    }

    public function dropMorphedAuditColumns(Blueprint $table): void
    {
        $table->dropIndex(['creater_id', 'creater_type']);
        $table->dropIndex(['updater_id', 'updater_type']);
        $table->dropIndex(['deleter_id', 'deleter_type']);
        $table->dropIndex(['restorer_id', 'restorer_type']);

        $table->dropColumn('creater_id');
        $table->dropColumn('creater_type');
        $table->dropColumn('updater_id');
        $table->dropColumn('updater_type');
        $table->dropColumn('deleter_id');
        $table->dropColumn('deleter_type');
        $table->dropColumn('restorer_id');
        $table->dropColumn('restorer_type');
        $table->dropColumn('restored_at');


    }
}
