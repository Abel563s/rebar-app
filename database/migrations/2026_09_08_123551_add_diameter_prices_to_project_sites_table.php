<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_sites', function (Blueprint $table) {
            $table->decimal('price_08', 10, 2)->nullable()->after('amount_needed_08');
            $table->decimal('price_10', 10, 2)->nullable()->after('price_08');
            $table->decimal('price_12', 10, 2)->nullable()->after('price_10');
            $table->decimal('price_14', 10, 2)->nullable()->after('price_12');
            $table->decimal('price_16', 10, 2)->nullable()->after('price_14');
            $table->decimal('price_20', 10, 2)->nullable()->after('price_16');
            $table->decimal('price_24', 10, 2)->nullable()->after('price_20');
            $table->decimal('price_32', 10, 2)->nullable()->after('price_24');
        });
    }

    public function down(): void
    {
        Schema::table('project_sites', function (Blueprint $table) {
            $table->dropColumn(['price_08', 'price_10', 'price_12', 'price_14', 'price_16', 'price_20', 'price_24', 'price_32']);
        });
    }
};
