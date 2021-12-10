<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position_titles', function (Blueprint $table) {
            $table->id('position_title_id');
            $table->foreignId('organization_id');
            $table->foreignId('position_category_id');
            $table->string('position_title');

            $table->foreign('organization_id')->references('organization_id')->on('organizations');
            $table->foreign('position_category_id')->references('position_category_id')->on('position_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('position_titles');
        $table->dropForeign('organization_id');
        $table->dropForeign('position_category_id');
    }
}
