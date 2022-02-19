<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGPOANotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gpoa_notifications', function (Blueprint $table) {
            $table->id('notification_id');
            $table->foreignId('organization_id');
            $table->foreignId('event_id');
            $table->string('message');
            $table->timestamps();

            $table->foreign('event_id')->references('upcoming_event_id')->on('upcoming_events');
            $table->foreign('organization_id')->references('organization_id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('g_p_o_a__notifications');
    }
}
