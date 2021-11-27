<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_documents', function (Blueprint $table) {
            $table->id('organization_document_id');
            $table->foreignId('organization_document_type_id');
            $table->string('file');
            $table->string('title');
            $table->string('description');
            $table->date('effective_date');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organization_document_type_id')->references('organization_document_type_id')->on('organization_document_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_documents');
        $table->dropForeign('organization_document_type_id');
    }
}
