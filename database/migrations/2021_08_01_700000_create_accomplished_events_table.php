<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccomplishedEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accomplished_events', function (Blueprint $table) {
            $table->id('accomplished_event_id');
            $table->foreignId('organization_id');
            $table->foreignId('event_category_id');
            $table->foreignId('event_role_id');
            $table->foreignId('event_nature_id');
            $table->foreignId('event_classification_id');
            $table->foreignId('level_id');
            $table->foreignId('fund_source_id');
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
            $table->unsignedInteger('total_beneficiary');
            $table->string('sponsors');
            $table->unsignedInteger('budget')->nullable()->default(NULL);
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organization_id')->references('organization_id')->on('organizations');
            $table->foreign('event_category_id')->references('event_category_id')->on('event_categories');
            $table->foreign('event_nature_id')->references('event_nature_id')->on('event_natures');
            $table->foreign('event_classification_id')->references('event_classification_id')->on('event_classifications');
            $table->foreign('event_role_id')->references('event_role_id')->on('event_roles');
            $table->foreign('level_id')->references('level_id')->on('levels');
            $table->foreign('fund_source_id')->references('fund_source_id')->on('fund_sources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accomplished_events');
        $table->dropForeign('organization_id');
        $table->dropForeign('event_category_id');
        $table->dropForeign('event_role_id');
        $table->dropForeign('level_id');
        $table->dropForeign('fund_source_id');
    }
}
