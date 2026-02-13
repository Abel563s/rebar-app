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
        if (!Schema::hasColumn('rebar_requirements', 'site_id')) {
            Schema::table('rebar_requirements', function (Blueprint $table) {
                $table->foreignId('site_id')->after('id')->nullable()->constrained('project_sites')->cascadeOnDelete();
            });
        }

        if (!Schema::hasColumn('offcuts', 'site_id')) {
            Schema::table('offcuts', function (Blueprint $table) {
                $table->foreignId('site_id')->after('id')->nullable()->constrained('project_sites')->cascadeOnDelete();
            });
        }

        if (!Schema::hasColumn('rebar_cutting_logs', 'site_id')) {
            Schema::table('rebar_cutting_logs', function (Blueprint $table) {
                $table->foreignId('site_id')->after('id')->nullable()->constrained('project_sites')->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rebar_requirements', function (Blueprint $table) {
            $table->dropConstrainedForeignId('site_id');
        });

        Schema::table('offcuts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('site_id');
        });

        Schema::table('rebar_cutting_logs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('site_id');
        });
    }
};
