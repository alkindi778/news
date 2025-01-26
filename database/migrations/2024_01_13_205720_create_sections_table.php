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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type'); // category, popular, latest, featured, custom
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->text('content')->nullable();
            $table->integer('items_count')->default(6);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('show_title')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
