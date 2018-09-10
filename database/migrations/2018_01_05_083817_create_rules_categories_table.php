<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRulesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rule_id');
            $table->integer('category_id');
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')->on('categories');

            $table->foreign('rule_id')
                ->references('id')->on('rules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rules_categories');
    }
}
