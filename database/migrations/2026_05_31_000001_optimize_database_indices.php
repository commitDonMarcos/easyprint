<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $usedNames = [];

    public function up(): void
    {
        Schema::table('useopr_projects', function (Blueprint $table) {
            $table->index('session_id', 'idx_projects_session_id');
            $table->index('local_storage_key', 'idx_projects_local_storage_key');
            $table->index('template_id', 'idx_projects_template_id');
            $table->index('created_at', 'idx_projects_created_at');
        });

        Schema::table('usage_logs', function (Blueprint $table) {
            $table->index('session_id', 'idx_usage_logs_session_id');
            $table->index('template_id', 'idx_usage_logs_template_id');
            $table->index('action', 'idx_usage_logs_action');
            $table->index('created_at', 'idx_usage_logs_created_at');
        });

        Schema::table('template_statistics', function (Blueprint $table) {
            $table->index('date', 'idx_stats_date');
            $table->unique(['template_id', 'date'], 'unq_stats_template_date');
        });

        Schema::table('templates', function (Blueprint $table) {
            $table->unique('slug', 'unq_templates_slug');
        });
    }

    public function down(): void
    {
        Schema::table('useopr_projects', function (Blueprint $table) {
            $table->dropIndex('idx_projects_session_id');
            $table->dropIndex('idx_projects_local_storage_key');
            $table->dropIndex('idx_projects_template_id');
            $table->dropIndex('idx_projects_created_at');
        });

        Schema::table('usage_logs', function (Blueprint $table) {
            $table->dropIndex('idx_usage_logs_session_id');
            $table->dropIndex('idx_usage_logs_template_id');
            $table->dropIndex('idx_usage_logs_action');
            $table->dropIndex('idx_usage_logs_created_at');
        });

        Schema::table('template_statistics', function (Blueprint $table) {
            $table->dropIndex('idx_stats_date');
            $table->dropUnique('unq_stats_template_date');
        });

        Schema::table('templates', function (Blueprint $table) {
            $table->dropUnique('unq_templates_slug');
        });
    }
};
