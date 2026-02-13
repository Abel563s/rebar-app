<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Rebar Requirements
        Schema::create('rebar_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id')->unique()->index();
            $table->string('structural_element');
            $table->integer('bar_diameter'); // mm
            $table->integer('required_length'); // mm
            $table->integer('quantity');
            $table->decimal('total_length', 15, 2); // meters, increased precision just in case
            $table->string('drawing_reference')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        // 2. Off-Cuts
        Schema::create('offcuts', function (Blueprint $table) {
            $table->id();
            $table->string('offcut_code')->unique()->index();
            $table->integer('bar_diameter');
            $table->integer('length'); // mm
            $table->integer('quantity')->default(1);
            $table->string('storage_location')->nullable();
            $table->enum('status', ['Available', 'Used', 'Scrap'])->default('Available');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        // 3. Rebar Cutting Logs
        Schema::create('rebar_cutting_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rebar_requirement_id')->constrained('rebar_requirements')->cascadeOnDelete();
            $table->date('date');
            $table->integer('bar_diameter');
            $table->integer('original_length'); // mm
            $table->integer('cut_length'); // mm
            $table->integer('remaining_length'); // mm
            // Nullable FK to the produced offcut
            $table->foreignId('offcut_id')->nullable()->constrained('offcuts')->nullOnDelete();
            $table->string('used_for')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rebar_cutting_logs');
        Schema::dropIfExists('offcuts');
        Schema::dropIfExists('rebar_requirements');
    }
};
