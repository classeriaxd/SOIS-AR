<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_replies', function (Blueprint $table) {
            $table->id('reply_id');
            
            $table->foreignId('user_id');
            $table->foreignId('message_id');
            $table->foreignId('organization_id');

            $table->string('reply');
            $table->string('status')->default('unread');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('message_id')->references('message_id')->on('membership_messages');
            $table->foreign('organization_id')->references('organization_id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('membership_replies');
    }
}
