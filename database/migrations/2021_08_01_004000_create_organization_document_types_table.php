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
            $table->id('organization_document_type_id');
            $table->foreignId('organization_id');
            $table->string('type');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('organization_document_types');
        $table->dropForeign('organization_id');
    }
}
