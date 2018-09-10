<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('partners', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name',255);
		    $table->string('slug',255);
		    $table->string('photo',255);
		    $table->string('url',255);
		    $table->string('about', 255);
		    $table->boolean('publish')->default(false);
		    $table->timestamps();
	    });

	    Schema::create('partners_statements', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('partner_id');
		    $table->integer('statement_id');
		    $table->timestamps();

		    $table->foreign('partner_id')->references('id')
			    ->on('partners');
		    $table->foreign('statement_id')->references('id')
			    ->on('statements');
	    });

	    Schema::table('categories', function (Blueprint $table) {
		    $table->integer('parent_id')->default(0);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('categories', function (Blueprint $table) {
		    $table->dropColumn('parent_id');
	    });
	    Schema::dropIfExists('partners_statements');
	    Schema::dropIfExists('partners');
    }
}
