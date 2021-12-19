<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccomplishmentReportsAltTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Should Contain PDF Versions of Tabular XLSX Accomplishment Reports
        Schema::create('accomplishment_reports_alt', function (Blueprint $table) {
            $table->id('accomplishment_report_alt_id');
            $table->foreignId('accomplishment_report_id');
            // Accomplishment Report Type - 1 = PDF
            $table->unsignedTinyInteger('accomplishment_report_type');
            $table->string('file');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('accomplishment_report_id')->references('accomplishment_report_id')->on('accomplishment_reports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accomplishment_report_id');
    }
}
