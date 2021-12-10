<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id('organization_id');
            $table->foreignId('organization_type_id');
            $table->string('organization_name');
            $table->string('organization_acronym');
            $table->text('organization_details');
            $table->string('organization_primary_color');
            $table->string('organization_secondary_color');
            $table->string('organization_slug')->unique();
            $table->timestamps();

            $table->foreign('organization_type_id')->references('organization_type_id')->on('organization_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');

        $table->dropForeign('organization_type_id');
    }
}
