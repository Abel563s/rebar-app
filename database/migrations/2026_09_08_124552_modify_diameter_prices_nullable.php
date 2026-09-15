<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_sites', function (Blueprint $table) {
            $table->decimal('price_08', 10, 2)->nullable()->default(null)->change();
            $table->decimal('price_10', 10, 2)->nullable()->default(null)->change();
            $table->decimal('price_12', 10, 2)->nullable()->default(null)->change();
            $table->decimal('price_14', 10, 2)->nullable()->default(null)->change();
            $table->decimal('price_16', 10, 2)->nullable()->default(null)->change();
            $table->decimal('price_20', 10, 2)->nullable()->default(null)->change();
            $table->decimal('price_24', 10, 2)->nullable()->default(null)->change();
            $table->decimal('price_32', 10, 2)->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('project_sites', function (Blueprint $table) {
            $table->decimal('price_08', 10, 2)->default(12.00)->change();
            $table->decimal('price_10', 10, 2)->default(18.50)->change();
            $table->decimal('price_12', 10, 2)->default(26.00)->change();
            $table->decimal('price_14', 10, 2)->default(35.50)->change();
            $table->decimal('price_16', 10, 2)->default(46.00)->change();
            $table->decimal('price_20', 10, 2)->default(72.00)->change();
            $table->decimal('price_24', 10, 2)->default(105.00)->change();
            $table->decimal('price_32', 10, 2)->default(185.00)->change();
        });
    }
};
