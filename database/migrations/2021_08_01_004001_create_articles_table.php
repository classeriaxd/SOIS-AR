<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id('articles_id');
            $table->string('article_title');
            $table->string('article_subtitle');
            $table->string('article_content');

            $table->integer('type')->nullable();
            $table->string('image')->nullable();
            $table->integer('status')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');

            $table->string('article_slug');

            $table->boolean('is_featured_in_newspage')->nullable();

            $table->boolean('is_article_featured_landing_page')->nullable();

            $table->integer('is_article_featured_organization_page')->nullable();

            $table->boolean('is_article_top_news_organization_page')->nullable();
            
            $table->boolean('is_article_featured_home_page')->nullable();

            $table->unsignedBigInteger('organization_id')->nullable();
            $table->foreign('organization_id')->references('organization_id')->on('organizations');

            $table->boolean('is_carousel_homepage')->nullable();
            $table->boolean('is_carousel_org_page')->nullable();

            $table->unsignedBigInteger('article_type_id')->nullable();
            $table->foreign('article_type_id')->references('article_types_id')->on('article_types');


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
        Schema::dropIfExists('articles');
    }
}
