<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('visits', function (Blueprint $table) {
            if (!Schema::hasColumn('visits', 'page_url')) {
                $table->text('page_url')->nullable();
            }
            if (!Schema::hasColumn('visits', 'referrer')) {
                $table->text('referrer')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn(['page_url', 'referrer']);
        });
    }
};
