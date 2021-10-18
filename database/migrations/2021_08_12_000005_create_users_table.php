<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->foreignId('course_id')->nullable();
            $table->foreignId('role_id');

            $table->string('email')->unique();
            $table->string('password');
            $table->string('student_number')->unique()->nullable();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->unsignedTinyInteger('gender');
            $table->date('date_of_birth');
            $table->string('mobile_number');
            $table->text('address');
            $table->timestamps();
            $table->unsignedTinyInteger('status');

            $table->foreign('course_id')->references('course_id')->on('courses');
            $table->foreign('role_id')->references('role_id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        $table->dropForeign('course_id');
        $table->dropForeign('role_id');
    }
}
