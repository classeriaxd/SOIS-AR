<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAccomplishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_accomplishments', function (Blueprint $table) {
            $table->id('student_accomplishment_id');
            $table->foreignId('user_id');
            $table->foreignId('organization_id');
            $table->foreignId('level_id')->nullable()->default(NULL);
            $table->foreignId('fund_source_id')->nullable()->default(NULL);
            $table->foreignId('accomplished_event_id')->nullable()->default(NULL);
            $table->foreignId('event_category_id')->nullable()->default(NULL);

            $table->uuid('accomplishment_uuid')->unique();
            $table->string('title');
            $table->text('description');
            $table->text('objective');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('venue');
            $table->string('organizer');
            $table->string('activity_type')->nullable()->default(NULL);
            $table->string('beneficiaries')->nullable()->default(NULL);
            $table->unsignedInteger('budget')->nullable()->default(NULL);
            // Status: 1 - PENDING | 2 - APPROVED | 3 - DISAPPROVED
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('reviewed_by')->nullable()->default(NULL);
            $table->timestamp('reviewed_at')->nullable()->default(NULL);
            $table->string('remarks')->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('organization_id')->references('organization_id')->on('organizations');
            $table->foreign('level_id')->references('level_id')->on('levels');
            $table->foreign('fund_source_id')->references('fund_source_id')->on('fund_sources');
            $table->foreign('accomplished_event_id')->references('accomplished_event_id')->on('accomplished_events');
            $table->foreign('event_category_id')->references('event_category_id')->on('event_categories');
            $table->foreign('reviewed_by')->references('user_id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_accomplishments');
        $table->dropForeign('user_id');
        $table->dropForeign('organization_id');
        $table->dropForeign('level_id');
        $table->dropForeign('fund_source_id');
        $table->dropForeign('accomplished_event_id');
        $table->dropForeign('event_category_id');
        $table->dropForeign('reviewed_by');
    }
}
