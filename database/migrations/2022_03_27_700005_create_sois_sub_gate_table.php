<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoisSubGateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sois_sub_gates', function (Blueprint $table) {
            $table->id('sois_sub_gates_id');

            $table->foreignId('sub_under_for');
            $table->foreign('sub_under_for')->references('sois_links_id')->on('sois_links');
            
            $table->text('sub_name');
            $table->text('sub_description');
            $table->text('sub_link');

            
            $table->boolean('status');

            $table->foreignId('role_id')->nullable();
            $table->foreignId('user_id')->nullable();

            $table->foreign('role_id')->references('role_id')->on('roles');
            $table->foreign('user_id')->references('user_id')->on('users');

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
        Schema::dropIfExists('sois_sub_gates');
    }
}
