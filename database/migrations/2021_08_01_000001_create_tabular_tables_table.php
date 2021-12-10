<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabularTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabular_tables', function (Blueprint $table) {
            $table->id('tabular_table_id');
            $table->string('tabular_table_name');
            $table->unsignedInteger('reference_table_number')->nullable()->default(NULL);
            $table->text('description')->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabular_tables');
    }
}
