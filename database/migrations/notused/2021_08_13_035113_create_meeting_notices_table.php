<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_notices', function (Blueprint $table) {
            $table->id('meetingnotice_id');
            $table->string('notice_uuid')->unique();
            $table->string('for');
            $table->string('from');
            $table->date('creation_date');
            $table->datetime('meeting_date');
            $table->string('venue');
            $table->text('objectives');
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
        Schema::dropIfExists('meeting_notices');
    }
}
