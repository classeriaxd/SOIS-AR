<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultInterfacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_interfaces', function (Blueprint $table) {
            $table->id('default_interfaces_id');
            $table->string('interface_name');
            $table->string('interface_description');
            $table->string('interface_primary_color');
            $table->string('interface_secondary_color');
            $table->string('interface_tertiary_color');
            $table->string('interface_primary_text_color');
            $table->string('interface_secondary_text_color');
            $table->integer('interface_type');

            $table->unsignedBigInteger('interface_type_id');
            $table->foreign('interface_type_id')->references('interface_types_id')->on('interface_types');

            $table->integer('status');
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
        Schema::dropIfExists('default_interfaces');
    }
}
