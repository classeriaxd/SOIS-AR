<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationMenusNavigationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigation_menus_navigation_types', function (Blueprint $table) {
            $table->id('navigation_menus_navigation_types_id');

            $table->unsignedBigInteger('navigation_menu_id');
            $table->foreign('navigation_menu_id')->references('navigation_menus_id')->on('navigation_menus');

            $table->unsignedBigInteger('navigation_type_id');
            $table->foreign('navigation_type_id')->references('navigation_menu_types_id')->on('navigation_menu_types');

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
        Schema::dropIfExists('navigation_menus_navigation_types');
    }
}
