<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id('announcements_id');
            $table->string('announcement_title')->unique();
            $table->string('announcement_content')->nullable();
            $table->string('signature')->nullable();
            $table->string('signer_position')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');

            $table->boolean('status')->nullable();

            $table->date('exp_date')->nullable();
            $table->time('exp_time', $precicion = 0)->nullable();

            $table->unsignedBigInteger('organization_id')->nullable();
            $table->foreign('organization_id')->references('organization_id')->on('organizations');

            $table->boolean('isAnnouncementInHomepage')->nullable();

            $table->string('announcement_slug')->nullable();

            $table->boolean('isAnnouncementInOrgpage')->nullable();

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
        Schema::dropIfExists('announcements');
    }
}
