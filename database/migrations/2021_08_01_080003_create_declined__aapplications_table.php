<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeclinedAapplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('declined_aapplications', function (Blueprint $table) {
            $table->id('declined_aapp_id');
            $table->foreignId('application_id');
            
            $table->string('reason');
            $table->timestamps();

            $table->foreign('application_id')->references('application_id')->on('academic_applications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('declined__aapplications');
    }
}
