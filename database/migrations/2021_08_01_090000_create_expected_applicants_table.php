<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpectedApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expected_applicants', function (Blueprint $table) {
            $table->id("expected_applicant_id");
            $table->foreignId('course_id');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('student_number')->unique();

            $table->foreign('course_id')->references('course_id')->on('courses');
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
        Schema::dropIfExists('expected_applicants');
    }
}
