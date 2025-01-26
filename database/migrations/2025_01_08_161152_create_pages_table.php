<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default pages
        DB::table('pages')->insert([
            [
                'title' => 'من نحن',
                'slug' => 'about-us',
                'content' => 'محتوى صفحة من نحن',
                'meta_description' => 'تعرف على صحيفتنا وأهدافنا',
                'meta_keywords' => 'من نحن، عن الصحيفة، أهدافنا',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'سياسة الخصوصية',
                'slug' => 'privacy-policy',
                'content' => 'محتوى سياسة الخصوصية',
                'meta_description' => 'سياسة الخصوصية وحماية البيانات',
                'meta_keywords' => 'سياسة الخصوصية، حماية البيانات، الخصوصية',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'الشروط والأحكام',
                'slug' => 'terms-conditions',
                'content' => 'محتوى الشروط والأحكام',
                'meta_description' => 'الشروط والأحكام الخاصة باستخدام الموقع',
                'meta_keywords' => 'الشروط والأحكام، قواعد الاستخدام',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
