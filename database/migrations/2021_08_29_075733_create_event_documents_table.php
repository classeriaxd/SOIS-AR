<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_documents', function (Blueprint $table) {
            $table->id('event_document_id');
            $table->foreignId('event_id');
            $table->foreignId('event_document_type_id');
            $table->string('title');
            $table->text('description');
            $table->string('file');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_documents');
        $table->foreign('event_id')->references('event_id')->on('events');
        $table->foreign('event_document_type_id')->references('event_document_type_id')->on('event_document_types');

    }
}
