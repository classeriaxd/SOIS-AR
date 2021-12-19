<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_applications', function (Blueprint $table) {
            $table->id('application_id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('membership_id');
            $table->unsignedBigInteger('course_id');
  
            $table->string('student_number');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('gender');
            $table->string('year_and_section');
            $table->date('date_of_birth');
            $table->string('contact');
            $table->string('address');
            $table->string('application_status')->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('membership_id')->references('academic_membership_id')->on('academic_membership')->onDelete('cascade');
            $table->foreign('course_id')->references('course_id')->on('courses')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_applications');
    }
}
