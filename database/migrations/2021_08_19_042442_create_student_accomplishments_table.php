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
            $table->id('student_accomplishments_id');
            $table->foreignId('organization_id');
            $table->string('title');
            $table->text('description');
            $table->unsignedTinyInteger('status');
            $table->text('remarks');
            $table->softDeletes();
            $table->timestamps();

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
        $table->dropForeign('organization_id');
    }
}
