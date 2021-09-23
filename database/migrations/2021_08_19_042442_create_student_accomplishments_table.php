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
            $table->uuid('accomplishment_uuid')->unique();
            $table->string('title');
            $table->text('description');
            $table->date('date_awarded');
            // Status: 0 - PENDING | 1 - APPROVED | 2 - DISAPPROVED
            $table->unsignedTinyInteger('status')->default(0);
            $table->foreignId('reviewed_by')->nullable()->default(NULL);
            $table->text('remarks')->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('organization_id')->references('organization_id')->on('organizations');
            $table->foreign('reviewed_by')->references('user_id')->on('users');

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
        $table->dropForeign('reviewed_by');
    }
}
