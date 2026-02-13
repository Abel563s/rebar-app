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
        Schema::create('project_sites', function (Blueprint $table) {
            $table->id();
            $table->string('site_code')->unique(); // PS-0001
            $table->string('project_name');
            $table->string('site_name');
            $table->string('location');
            $table->string('sector')->nullable();
            $table->enum('status', ['Active', 'Completed'])->default('Active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_sites');
    }
};
