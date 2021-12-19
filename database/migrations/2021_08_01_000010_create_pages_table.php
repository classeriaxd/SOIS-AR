<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id('pages_id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable() ;
            $table->longText('content')->nullable() ;
            $table->timestamps();


            $table->boolean('is_default_home')->nullable();
            $table->boolean('is_default_not_found')->nullable(); 
            $table->string('primary_color')->nulllable();
            $table->string('secondary_color')->nulllable();
            $table->string('tertiary_color')->nulllable();
            $table->string('quarternary_color')->nulllable();
            $table->integer('status')->nullable();

            $table->boolean('is_announcements_activated')->nullable();
            $table->boolean('is_events_activated')->nullable();
            $table->boolean('is_articles_activated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
