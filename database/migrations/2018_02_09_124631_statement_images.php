<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StatementImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statement_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('statement_id');
            $table->boolean('main')->default(false);
            $table->timestamps();

            $table->foreign('statement_id')
                ->references('id')->on('statements')
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
        Schema::dropIfExists('statement_images');
    }
}
