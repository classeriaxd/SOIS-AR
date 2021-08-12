<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_organization', function (Blueprint $table) {
            $table->foreignId('organization_id');
            $table->foreignId('course_id');

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
        Schema::dropIfExists('courses_organizations');
        $table->dropForeign('organization_id');
        $table->dropForeign('course_id');
    }
}
