<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rebar_cutting_logs', function (Blueprint $table) {
            $table->foreignId('reused_offcut_id')->nullable()->after('offcut_id')->constrained('offcuts')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rebar_cutting_logs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reused_offcut_id');
        });
    }
};
