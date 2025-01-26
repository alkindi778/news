<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newspaper_covers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('newspaper_name');
            $table->string('cover_image');
            $table->string('pdf_link');
            $table->date('publish_date');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newspaper_covers');
    }
};
