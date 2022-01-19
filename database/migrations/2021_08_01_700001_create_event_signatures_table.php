<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_signatures', function (Blueprint $table) {
            $table->id('signature_id');

            $table->foreignId('user_id');
            $table->foreignId('organization_id')->nullable();
            $table->foreignId('role_id');
            $table->string('signature_path');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('organization_id')->references('organization_id')->on('organizations');
            $table->foreign('role_id')->references('role_id')->on('roles');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_signatures');
    }
}
