<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('uuid');
            $table->string('phone')->unique();
            $table->string('avatar')->nullable();
            $table->enum('types', ['admin','volunteer','destitute','social-service'])->default('destitute');
            $table->integer('social_service_id')->nullable();
            $table->integer('organization_id')->nullable();
            $table->boolean('block')->default(0);
            $table->boolean('publish')->default(0);
            $table->string('position')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('social_service_id')->references('id')->on('social_services');
            $table->foreign('organization_id')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
