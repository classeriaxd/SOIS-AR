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
            $table->foreignId('gender_id')->nullable();

            $table->string('email')->unique();
            $table->string('password');
            $table->string('student_number')->unique()->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable()->default(NULL);
            $table->tinyText('title')->nullable()->default(NULL);
            $table->date('date_of_birth');
            $table->string('mobile_number');
            $table->text('address');
            $table->string('year_and_section')->nullable()->default(NULL);
            $table->date('email_verified_at')->nullable()->default(NULL);
            $table->timestamps();

            // 0 - Not Active/Enrolled/Dropped | 1 - Active/Current
            $table->unsignedTinyInteger('status');
            $table->text('two_factor_secret')->default(NULL)->nullable();
            $table->text('two_factor_recovery_code')->default(NULL)->nullable();
            $table->rememberToken();
            $table->foreign('gender_id')->references('gender_id')->on('genders');
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
        Schema::dropIfExists('users');
        $table->dropForeign('course_id');
        $table->dropForeign('gender_id');
    }
}
