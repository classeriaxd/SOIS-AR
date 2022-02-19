<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventPartnershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_partnerships', function (Blueprint $table) {
            $table->id('event_partnership_id');
            $table->foreignId('event_id');
            $table->foreignId('partnership_to');
            $table->timestamps();

            $table->foreign('event_id')->references('upcoming_event_id')->on('upcoming_events');
            $table->foreign('partnership_to')->references('organization_id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event__partnerships');
    }
}
