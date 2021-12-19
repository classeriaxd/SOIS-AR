<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigation_menus', function (Blueprint $table) {
            $table->id('navigation_menus_id');
            $table->integer('sequence');
            $table->integer('type');

            
            $table->string('label');
            $table->string('slug');

            $table->boolean('is_topnav')->nullable();
            $table->boolean('is_footer')->nullable();

            
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
        Schema::dropIfExists('navigation_menus');
    }
}
