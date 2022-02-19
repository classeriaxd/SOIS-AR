<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Null_;

class CreatePartnershipsRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partnership_requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->foreignId('event_id');
            $table->foreignId('request_by');
            $table->foreignId('request_to');
            $table->string('reason')->nullable()->default(NULL);
            $table->string('request_status')->default('pending'); //values = accepted/declined/pending
            $table->timestamps();

            $table->foreign('event_id')->references('upcoming_event_id')->on('upcoming_events');
            $table->foreign('request_by')->references('organization_id')->on('organizations');
            $table->foreign('request_to')->references('organization_id')->on('organizations');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partnerships__requests');
    }
}
