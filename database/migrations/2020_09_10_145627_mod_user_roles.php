<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModUserRoles extends Migration
{
    public function up()
    {
        Schema::table('user_roles', function (Blueprint $table) {
            $table->string('display_name')->default('[GM]');
        });
    }

    public function down()
    {
        Schema::table('user_roles', function (Blueprint $table) {
            $table->dropColumn('display_name');
        });
    }
}
