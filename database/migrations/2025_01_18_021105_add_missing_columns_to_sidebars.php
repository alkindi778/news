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
        Schema::table('sidebars', function (Blueprint $table) {
            if (!Schema::hasColumn('sidebars', 'type')) {
                $table->string('type')->after('title');
            }
            if (!Schema::hasColumn('sidebars', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('type')->constrained('categories')->nullOnDelete();
            }
            if (!Schema::hasColumn('sidebars', 'posts_count')) {
                $table->integer('posts_count')->nullable()->after('category_id');
            }
            if (!Schema::hasColumn('sidebars', 'layout_type')) {
                $table->string('layout_type')->nullable()->after('posts_count');
            }
            if (!Schema::hasColumn('sidebars', 'ad_id')) {
                $table->foreignId('ad_id')->nullable()->after('layout_type')->constrained('advertisements')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sidebars', function (Blueprint $table) {
            if (Schema::hasColumn('sidebars', 'category_id')) {
                $table->dropForeign(['category_id']);
            }
            if (Schema::hasColumn('sidebars', 'ad_id')) {
                $table->dropForeign(['ad_id']);
            }
            
            $columns = ['type', 'category_id', 'posts_count', 'layout_type', 'ad_id'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('sidebars', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
