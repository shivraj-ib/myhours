<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InstallSchema extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (false === Schema::hasTable('roles'))
            Schema::create('roles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('role_name');
                $table->boolean('active')->default(1);
                $table->timestamps();
            });
        if (false === Schema::hasTable('teams'))
            Schema::create('teams', function (Blueprint $table) {
                $table->increments('id');
                $table->string('team_name');
                $table->boolean('active')->default(1);
                $table->timestamps();
            });
        if (false === Schema::hasTable('permissions'))
            Schema::create('permissions', function (Blueprint $table) {
                $table->increments('id');
                $table->string('perm_name');
                $table->boolean('active')->default(1);
                $table->timestamps();
            });
        if (false === Schema::hasTable('users'))
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->integer('phone')->nullable();
                $table->string('thumb')->nullable();
                $table->rememberToken();
                $table->timestamps();
                $table->integer('role_id')->unsigned();
                $table->foreign('role_id')->references('id')->on('roles');
                $table->boolean('active')->default(1);
            });
        if (false === Schema::hasTable('password_resets'))
            Schema::create('password_resets', function (Blueprint $table) {
                $table->string('email')->index();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });


        if (false === Schema::hasTable('hours'))
            Schema::create('hours', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');
                $table->string('title');
                $table->longText('content');
                $table->date('activity_date');
                $table->timestamps();
            });
        if (false === Schema::hasTable('user_team'))
            Schema::create('user_team', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->integer('team_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('team_id')->references('id')->on('teams');
                $table->timestamps();
            });
        if (false === Schema::hasTable('role_permission'))
            Schema::create('role_permission', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('role_id')->unsigned();
                $table->integer('permission_id')->unsigned();
                $table->foreign('role_id')->references('id')->on('roles');
                $table->foreign('permission_id')->references('id')->on('permissions');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('hours');
        Schema::dropIfExists('user_team');
        Schema::dropIfExists('role_permission');
    }

}
