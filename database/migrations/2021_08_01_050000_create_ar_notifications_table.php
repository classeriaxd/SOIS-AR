<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateARNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_notifications', function (Blueprint $table) {
            $table->id('ar_notification_id');
            $table->foreignId('user_id');
            $table->string('title');
            $table->text('description')->nullable();
            // Types > 1=System | 2=Event(GPOA)| 3=StudentAccomplishment| 4=AccomplishmentRport
            $table->unsignedTinyInteger('type');
            $table->uuid('link')->nullable();
            $table->timestamp('read_at')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
        $table->dropForeign('user_id');
    }
}
