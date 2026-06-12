<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('approvals', function (Blueprint $table) {
            $table->unsignedBigInteger('target_site_id')->nullable()->after('site_id');
            $table->foreign('target_site_id')->references('id')->on('project_sites')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('approvals', function (Blueprint $table) {
            $table->dropForeign(['target_site_id']);
            $table->dropColumn('target_site_id');
        });
    }
};
