<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', array('saved','sent','accepted','closed'))->default('saved');
            $table->boolean('repeat')->default(false);
            $table->boolean('published')->default(false);
            $table->json('days')->nullable();
            $table->dateTime('published_date')->nullable();
            $table->dateTime('accept_date')->nullable();
            $table->dateTime('close_date')->nullable();
            $table->integer('user_id');
            $table->string('title');
            $table->text('description');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
