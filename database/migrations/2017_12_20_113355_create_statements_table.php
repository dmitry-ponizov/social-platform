<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->unsignedInteger('parent_id')->default(0);
            $table->string('title')->nullable();
            $table->enum('status', array('sent','accepted','closed','no_done'))->default('sent');
            $table->integer('sum')->nullable();
            $table->integer('raised')->nullable();
            $table->integer('category_id');
            $table->boolean('repeat')->nullable();
            $table->text('comment')->nullable();
            $table->integer('rate')->nullable();
            $table->json('days')->nullable();
            $table->boolean('published')->default(false);
            $table->integer('social_service_id')->nullable();
            $table->integer('organization_id')->nullable();
            $table->dateTime('execution_date')->nullable();
            $table->integer('user_id');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('social_service_id')
                ->references('id')->on('social_services');

            $table->foreign('organization_id')
                ->references('id')->on('organizations');

            $table->foreign('category_id')
                ->references('id')->on('categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statements');
    }
}
