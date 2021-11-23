<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAccomplishmentFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_accomplishment_files', function (Blueprint $table) {
            $table->id('student_accomplishment_file_id');
            $table->foreignId('student_accomplishment_id');
            $table->foreignId('SA_document_type_id');
            // type: 1 - IMG | 2 - PDF
            $table->unsignedTinyInteger('type');
            $table->string('file');
            $table->text('caption')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('student_accomplishment_id')->references('student_accomplishment_id')->on('student_accomplishments')->onDelete('cascade');
            $table->foreign('SA_document_type_id')->references('SA_document_type_id')->on('SA_document_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_accomplishment_files');
        $table->dropForeign('student_accomplishment_id');
        $table->dropForeign('SA_document_type_id');
    }
}
