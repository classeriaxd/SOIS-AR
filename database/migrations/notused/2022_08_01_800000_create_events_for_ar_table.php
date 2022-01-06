<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsForArTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_for_ar', function (Blueprint $table) {
            
           
            $table->foreignId('upcoming_event_id');
            $table->foreignId('accomplished_event_id')->nullable()->default(null);
          
            $table->foreign('upcoming_event_id')->references('upcoming_event_id')->on('upcoming_events');
            $table->foreign('accomplished_event_id')->references('accomplished_event_id')->on('accomplished_events');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events_for_ars');
    }
}
