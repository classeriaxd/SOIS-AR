<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoisGatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sois_gates', function (Blueprint $table) {
            $table->id('sois_gates_id');

            $table->foreignId('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');

            $table->boolean('is_logged_in')->nullable();
            $table->string('gate_key')->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sois_gates');
    }
}
