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
        Schema::table('rebar_cutting_logs', function (Blueprint $table) {
            $table->integer('quantity_cut')->default(1)->after('rebar_requirement_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rebar_cutting_logs', function (Blueprint $table) {
            $table->dropColumn('quantity_cut');
        });
    }
};
