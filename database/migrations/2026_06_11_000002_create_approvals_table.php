<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id');
            $table->unsignedBigInteger('offcut_id')->nullable();
            $table->unsignedBigInteger('requested_by');
            $table->unsignedBigInteger('approver_id')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('project_sites')->onDelete('cascade');
            $table->foreign('offcut_id')->references('id')->on('offcuts')->onDelete('set null');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('approvals');
    }
};
