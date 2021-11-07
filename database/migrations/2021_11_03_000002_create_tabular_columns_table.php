<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabularColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabular_columns', function (Blueprint $table) {
            $table->id('tabular_column_id');
            $table->foreignId('tabular_table_id');
            $table->string('tabular_column_name');
            $table->text('description')->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tabular_table_id')->references('tabular_table_id')->on('tabular_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabular_columns');
        $table->dropForeign('tabular_table_id');
    }
}
