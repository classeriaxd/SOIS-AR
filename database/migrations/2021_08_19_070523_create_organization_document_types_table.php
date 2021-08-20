<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_document_types', function (Blueprint $table) {
            $table->id('orgdoctype_id');
            $table->foreignId('org_id');
            $table->string('doctype');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('org_id')->references('organization_id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_document_types');
    }
}
