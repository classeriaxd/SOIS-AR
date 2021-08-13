<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_assets', function (Blueprint $table) {
            $table->id('organization_asset_id');
            $table->foreignId('organization_id');
            $table->string('image');
            $table->unsignedTinyInteger('type');
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
        Schema::dropIfExists('organization_assets');
        $table->dropForeign('organization_id');
    }
}
