<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupToPermissionsTable extends Migration
{
    public function up()
    {
        Schema::table('spatie_permissions', function (Blueprint $table) {
            $table->string('group')->nullable()->after('guard_name');
        });
    }

    public function down()
    {
        Schema::table('spatie_permissions', function (Blueprint $table) {
            $table->dropColumn('group');
        });
    }
}
