<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonAcademicMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_academic_members', function (Blueprint $table) {
            $table->id('non_academic_member_id');
            
            $table->unsignedBigInteger('membership_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('organization_id');
            $table->string('student_number');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('gender');
            $table->string('course');
            $table->string('year_and_section');
            $table->date('date_of_birth');
            $table->string('contact');
            $table->string('address');
            $table->string('membership_status')->default('unpaid');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('membership_id')->references('non_academic_membership_id')->on('non_academic_membership');
            $table->foreign('organization_id')->references('organization_id')->on('organizations');
            $table->foreign('course_id')->references('course_id')->on('courses');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('non_academic_members');
    }
}
