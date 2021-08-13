<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPositionTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_position_titles', function (Blueprint $table) {
            $table->foreignId('position_title_id');
            $table->foreignId('user_id');

            $table->foreign('position_title_id')->references('position_title_id')->on('position_titles');
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_positions_titles');
        $table->dropForeign('position_title_id');
        $table->dropForeign('user_id');

    }
}
