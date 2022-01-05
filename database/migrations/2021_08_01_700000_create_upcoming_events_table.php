<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpcomingEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upcoming_events', function (Blueprint $table) {
            $table->id('upcoming_event_id');

            $table->unsignedBigInteger('organization_id');

            $table->date('date');
            $table->string('title_of_activity');
            $table->string('objectives');
            $table->string('semester');
            $table->string('school_year');
            $table->string('participants');
            $table->string('partnerships');
            $table->string('venue');
            $table->time('time');
            $table->string('projected_budget');
            $table->string('sponsor');
            $table->string('fund_sourcing');
            $table->string('type_of_activity');
            $table->string('approval_status')->default('pending'); //values = pending/disapproved/approved
            $table->string('status')->default('upcoming'); //values = upcoming/accomplished
            $table->timestamps();

            $table->foreign('organization_id')->references('organization_id')->on('organizations')->onDelete('cascade');
            //$table->foreign('course_id')->references('course_id')->on('courses')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upcoming_events');
    }
}
