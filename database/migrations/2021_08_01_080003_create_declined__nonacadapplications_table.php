<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeclinedNonacadapplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('declined_naapplications', function (Blueprint $table) {
            $table->id('declined_naapp_id');
            $table->foreignId('application_id');
            
            $table->string('reason');
            $table->timestamps();

            $table->foreign('application_id')->references('application_id')->on('non_academic_applications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('declined__nonacadapplications');
    }
}
