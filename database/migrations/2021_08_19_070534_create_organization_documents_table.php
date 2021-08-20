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
            $table->id('orgdoc_id');
            $table->foreignId('org_id')->unique();
            $table->foreignId('orgdoc_type_id');
            $table->string('file');
            $table->string('title');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('org_id')->references('organization_id')->on('organizations');
            $table->foreign('orgdoc_type_id')->references('orgdoctype_id')->on('organization_document_types');
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
    }
}
