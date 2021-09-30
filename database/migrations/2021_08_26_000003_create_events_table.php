<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->foreignId('organization_id');
            $table->foreignId('event_category_id');
            $table->foreignId('event_role_id');
            $table->string('title');
            $table->text('description');
            $table->text('objective');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('venue');
            $table->string('activity_type');
            $table->string('beneficiaries');
            $table->string('sponsors');
            $table->integer('budget')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organization_id')->references('organization_id')->on('organizations');
            $table->foreign('event_category_id')->references('event_category_id')->on('event_categories');
            $table->foreign('event_role_id')->references('event_role_id')->on('event_roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
        $table->dropForeign('organization_id');
        $table->dropForeign('event_category_id');
        $table->dropForeign('event_role_id');
    }
}
