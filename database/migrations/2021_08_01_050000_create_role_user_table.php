<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id');
            $table->foreignId('user_id');
            $table->foreignId('organization_id')->nullable();

            $table->foreign('role_id')->references('role_id')->on('roles');
            $table->foreign('user_id')->references('user_id')->on('users');
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
        Schema::dropIfExists('role_user');
        $table->dropForeign('role_id');
        $table->dropForeign('user_id');
        $table->dropForeign('organization_id');
    }
}
