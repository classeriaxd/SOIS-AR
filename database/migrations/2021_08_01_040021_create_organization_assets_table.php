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
            $table->foreignId('asset_type_id');
            $table->string('file');
            $table->timestamps();
            
            $table->integer('is_latest_logo')->nullable();
            $table->integer('is_latest_banner')->nullable();
            $table->boolean('is_latest_image')->nullable();

            $table->unsignedBigInteger('user_id')->nullable()->default(NULL);
            $table->foreign('user_id')->references('user_id')->on('users');

            $table->unsignedBigInteger('page_type_id')->nullable()->default(NULL);
            $table->foreign('page_type_id')->references('page_types_id')->on('page_types');

            $table->foreign('organization_id')->references('organization_id')->on('organizations');
            $table->foreign('asset_type_id')->references('asset_type_id')->on('asset_types');

            $table->boolean('status');

            $table->unsignedBigInteger('announcement_id')->nullable();
            $table->foreign('announcement_id')->references('announcements_id')->on('announcements');

            $table->unsignedBigInteger('articles_id')->nullable();
            $table->foreign('articles_id')->references('articles_id')->on('articles');
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
        $table->dropForeign('asset_type_id');
    }
}
