<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompiledDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compiled_documents', function (Blueprint $table) {
            $table->id('compiled_document_id');
            $table->foreignId('organization_id');
            $table->foreignId('created_by');
            $table->string('title');
            $table->text('description');
            $table->string('file');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('created_by')->references('user_id')->on('users');
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
        Schema::dropIfExists('compiled_documents');
        $table->dropForeign('created_by');
        $table->dropForeign('organization_id');
    }
}
