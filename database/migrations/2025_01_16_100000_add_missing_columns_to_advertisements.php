<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('advertisements')) {
            Schema::table('advertisements', function (Blueprint $table) {
                if (!Schema::hasColumn('advertisements', 'title')) {
                    $table->string('title')->nullable();
                }
                if (!Schema::hasColumn('advertisements', 'link')) {
                    $table->string('link')->nullable();
                }
                if (!Schema::hasColumn('advertisements', 'position')) {
                    $table->string('position')->nullable();
                }
                if (!Schema::hasColumn('advertisements', 'image')) {
                    $table->string('image')->nullable();
                }
                if (!Schema::hasColumn('advertisements', 'active')) {
                    $table->boolean('active')->default(true);
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('advertisements')) {
            Schema::table('advertisements', function (Blueprint $table) {
                $table->dropColumn(['title', 'link', 'position', 'image', 'active']);
            });
        }
    }
};
