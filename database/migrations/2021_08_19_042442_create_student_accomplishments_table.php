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
            $table->string('accomplishment_uuid')->unique();
            $table->string('title');
            $table->text('description');
            $table->unsignedTinyInteger('status');
            $table->text('remarks');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
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
        Schema::dropIfExists('student_accomplishments');
        $table->dropForeign('user_id');
        $table->dropForeign('organization_id');
    }
}
