<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_members', function (Blueprint $table) {
            $table->id('academic_member_id');

            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('membership_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('organization_id');
            
            $table->integer('control_number');
            $table->string('student_number');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->string('email');
            $table->string('gender');
            $table->string('year_and_section');
            $table->date('date_of_birth');
            $table->string('contact');
            $table->string('address');
            $table->string('membership_status')->default('paid');
            $table->timestamps();


            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('membership_id')->references('academic_membership_id')->on('academic_membership');
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
        Schema::dropIfExists('academic_members');
    }
}
