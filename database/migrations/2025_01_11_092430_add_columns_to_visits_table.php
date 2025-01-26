<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('visits', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('visits', 'country')) {
                $table->string('country')->nullable();
            }
            if (!Schema::hasColumn('visits', 'city')) {
                $table->string('city')->nullable();
            }
            if (!Schema::hasColumn('visits', 'page_url')) {
                $table->text('page_url')->nullable();
            }
            if (!Schema::hasColumn('visits', 'referrer')) {
                $table->text('referrer')->nullable();
            }
            if (!Schema::hasColumn('visits', 'device_type')) {
                $table->string('device_type')->nullable();
            }
            if (!Schema::hasColumn('visits', 'browser')) {
                $table->string('browser')->nullable();
            }
            if (!Schema::hasColumn('visits', 'platform')) {
                $table->string('platform')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn(['country', 'city', 'page_url', 'referrer', 'device_type', 'browser', 'platform']);
        });
    }
};
