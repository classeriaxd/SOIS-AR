<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_images', function (Blueprint $table) {
            $table->id('event_image_id');
            $table->foreignId('accomplished_event_id');
            $table->unsignedTinyInteger('image_type');
            $table->string('image');
            $table->text('caption')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('accomplished_event_id')->references('accomplished_event_id')->on('accomplished_events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_images');
        $table->dropForeign('accomplished_event_id');
    }
}
