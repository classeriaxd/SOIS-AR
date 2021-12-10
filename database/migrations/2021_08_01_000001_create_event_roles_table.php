<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_roles', function (Blueprint $table) {
            $table->id('event_role_id');
            $table->string('event_role');
            $table->string('helper')->nullable();
            $table->char('background_color', 10)->default('#1976D2');
            $table->char('text_color', 10)->default('#FFFFFF');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_roles');
    }
}
