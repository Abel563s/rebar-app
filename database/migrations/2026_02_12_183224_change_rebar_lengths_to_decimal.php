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
        // 1. Rebar Requirements
        Schema::table('rebar_requirements', function (Blueprint $table) {
            $table->decimal('required_length', 15, 3)->change(); // In meters now
        });

        // 2. Off-Cuts
        Schema::table('offcuts', function (Blueprint $table) {
            $table->decimal('length', 15, 3)->change(); // In meters now
        });

        // 3. Rebar Cutting Logs
        Schema::table('rebar_cutting_logs', function (Blueprint $table) {
            $table->decimal('original_length', 15, 3)->change(); // In meters now
            $table->decimal('cut_length', 15, 3)->change(); // In meters now
            $table->decimal('remaining_length', 15, 3)->change(); // In meters now
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rebar_requirements', function (Blueprint $table) {
            $table->integer('required_length')->change();
        });

        Schema::table('offcuts', function (Blueprint $table) {
            $table->integer('length')->change();
        });

        Schema::table('rebar_cutting_logs', function (Blueprint $table) {
            $table->integer('original_length')->change();
            $table->integer('cut_length')->change();
            $table->integer('remaining_length')->change();
        });
    }
};
