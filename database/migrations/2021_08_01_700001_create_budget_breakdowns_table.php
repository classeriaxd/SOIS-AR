<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetBreakdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_breakdowns', function (Blueprint $table) {
            $table->id('breakdown_id');
            $table->foreignId('event_id');
            $table->string('name');
            $table->integer('amount');
            $table->timestamps();

            $table->foreign('event_id')->references('upcoming_event_id')->on('upcoming_events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_breakdowns');
    }
}
