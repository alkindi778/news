<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->string('media_title')->after('id');
            $table->text('media_description')->nullable()->after('media_title');
            $table->string('file_path')->after('media_description');
            $table->string('media_type')->after('file_path');
            $table->bigInteger('file_size')->after('media_type');
            $table->string('mime_type')->after('file_size');
            $table->string('media_status')->default('active')->after('mime_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn([
                'media_title',
                'media_description',
                'file_path',
                'media_type',
                'file_size',
                'mime_type',
                'media_status'
            ]);
        });
    }
};
