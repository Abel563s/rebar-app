<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rebar_requirements', function (Blueprint $table) {
            $table->string('steel_grade')->nullable()->after('bar_diameter');
            $table->decimal('weight_kg', 15, 2)->default(0)->after('total_length');
        });

        Schema::table('rebar_cutting_logs', function (Blueprint $table) {
            $table->string('steel_grade')->nullable()->after('bar_diameter');
            $table->decimal('weight_kg', 15, 2)->default(0)->after('remaining_length');
        });

        Schema::table('project_sites', function (Blueprint $table) {
            $table->decimal('amount_needed_08', 15, 2)->default(0);
            $table->decimal('amount_needed_10', 15, 2)->default(0);
            $table->decimal('amount_needed_12', 15, 2)->default(0);
            $table->decimal('amount_needed_14', 15, 2)->default(0);
            $table->decimal('amount_needed_16', 15, 2)->default(0);
            $table->decimal('amount_needed_18', 15, 2)->default(0);
            $table->decimal('amount_needed_20', 15, 2)->default(0);
            $table->decimal('amount_needed_24', 15, 2)->default(0);
            $table->decimal('amount_needed_28', 15, 2)->default(0);
            $table->decimal('amount_needed_32', 15, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('rebar_requirements', function (Blueprint $table) {
            $table->dropColumn(['steel_grade', 'weight_kg']);
        });

        Schema::table('rebar_cutting_logs', function (Blueprint $table) {
            $table->dropColumn(['steel_grade', 'weight_kg']);
        });

        Schema::table('project_sites', function (Blueprint $table) {
            $table->dropColumn([
                'amount_needed_08',
                'amount_needed_10',
                'amount_needed_12',
                'amount_needed_14',
                'amount_needed_16',
                'amount_needed_18',
                'amount_needed_20',
                'amount_needed_24',
                'amount_needed_28',
                'amount_needed_32',
            ]);
        });
    }
};
