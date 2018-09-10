<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('logo')->nullable();
        });

        Schema::create('organization_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('body',255)->nullable();
            $table->unsignedInteger('organization_id');
            $table->json('photo_report')->nullable();
            $table->timestamps();

            $table->foreign('organization_id')
                ->references('id')
                ->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_events');
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }
}
