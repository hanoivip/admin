<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRoles extends Migration
{
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->integer('user_id');
            $table->string('role');
            $table->primary('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
