<?php

use App\Models\upcoming_events;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisapprovedEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disapproved_events', function (Blueprint $table) {
            $table->id('disapproved_event_id');
            
            $table->foreignId('upcoming_event_id');
            $table->foreignId('disapproved_by');

            $table->string('reason');
            $table->timestamps();

            $table->foreign('disapproved_by')->references('user_id')->on('users');
            $table->foreign('upcoming_event_id')->references('upcoming_event_id')->on('upcoming_events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disapproved_events');
    }
}
