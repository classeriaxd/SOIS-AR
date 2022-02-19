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
            $table->foreignId('accomplished_event_id')->nullable()->default(NULL);

            $table->date('date');
            $table->string('title');
            $table->string('objectives');
            $table->string('head_organization');
            $table->string('semester');
            $table->string('school_year');
            $table->string('participants');
            $table->string('partnerships');
            $table->string('venue');
            $table->time('time');
            $table->integer('projected_budget')->nullable()->default(NULL);
            $table->string('sponsor');
            $table->string('fund_source');
            $table->string('activity_type');
            $table->string('advisers_approval')->default('pending'); //values = pending/disapproved/approved
            $table->string('studAffairs_approval')->default('pending'); //values = pending/disapproved/approved
            $table->string('directors_approval')->default('pending'); //values = pending/disapproved/approved
            $table->string('completion_status')->default('upcoming'); //values = upcoming/accomplished
            $table->string('partnership_status'); //values = on/off
            $table->timestamps();

            $table->foreign('organization_id')->references('organization_id')->on('organizations');
            $table->foreign('accomplished_event_id')->references('accomplished_event_id')->on('accomplished_events');
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
