<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficerPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('officer_positions', function (Blueprint $table) {
            $table->id('officer_positions_id');
            $table->boolean('status');
            $table->timestamps();

            $table->unsignedBigInteger('position_category');
            $table->foreign('position_category')->references('officer_positions_id')->on('officer_positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('officer_positions');
    }
}
