<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            // إضافة الأعمدة الجديدة فقط إذا لم تكن موجودة
            if (!Schema::hasColumn('settings', 'footer_about_text')) {
                $table->text('footer_about_text')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_logo')) {
                $table->string('footer_logo')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_bg_color')) {
                $table->string('footer_bg_color')->default('#1a1a1a');
            }
            if (!Schema::hasColumn('settings', 'footer_text_color')) {
                $table->string('footer_text_color')->default('#ffffff');
            }
            if (!Schema::hasColumn('settings', 'footer_link_color')) {
                $table->string('footer_link_color')->default('#60a5fa');
            }
            if (!Schema::hasColumn('settings', 'footer_link_hover_color')) {
                $table->string('footer_link_hover_color')->default('#3b82f6');
            }
            if (!Schema::hasColumn('settings', 'footer_quick_link1_text')) {
                $table->string('footer_quick_link1_text')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_quick_link1_url')) {
                $table->string('footer_quick_link1_url')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_quick_link2_text')) {
                $table->string('footer_quick_link2_text')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_quick_link2_url')) {
                $table->string('footer_quick_link2_url')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_quick_link3_text')) {
                $table->string('footer_quick_link3_text')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_quick_link3_url')) {
                $table->string('footer_quick_link3_url')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_copyright_text')) {
                $table->string('footer_copyright_text')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'footer_about_text',
                'footer_logo',
                'footer_bg_color',
                'footer_text_color',
                'footer_link_color',
                'footer_link_hover_color',
                'footer_quick_link1_text',
                'footer_quick_link1_url',
                'footer_quick_link2_text',
                'footer_quick_link2_url',
                'footer_quick_link3_text',
                'footer_quick_link3_url',
                'footer_copyright_text'
            ]);
        });
    }
};
