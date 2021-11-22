<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccomplishmentReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accomplishment_reports', function (Blueprint $table) {
            $table->id('accomplishment_report_id');
            // Accomplishment Report Type - 1 = Tabular | 2 = Design
            $table->foreignId('accomplishment_report_type_id');
            $table->uuid('accomplishment_report_uuid')->unique();
            $table->foreignId('organization_id');
            $table->foreignId('created_by');
            $table->string('title');
            $table->text('description')->nullable()->default(NULL);
            $table->string('file');

            // range title - 1 = Semestral | 2 = Quarterly | 3 = Custom
            $table->unsignedTinyInteger('range_title');
            $table->date('start_date');
            $table->date('end_date');

            // status - 1 = PENDING | 2 = ACCEPTED | 3 = DECLINED
            $table->unsignedTinyInteger('status')->default(1);
            
            $table->foreignId('reviewed_by')->nullable()->default(NULL);
            $table->timestamp('reviewed_at')->nullable()->default(NULL);
            $table->text('remarks')->nullable()->default(NULL);
            $table->timestamp('read_at')->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('accomplishment_report_type_id')->references('accomplishment_report_type_id')->on('accomplishment_report_types');
            $table->foreign('organization_id')->references('organization_id')->on('organizations');
            $table->foreign('created_by')->references('user_id')->on('users');
            $table->foreign('reviewed_by')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accomplishment_reports');
        $table->dropForeign('accomplishment_report_type_id');
        $table->dropForeign('organization_id');
        $table->dropForeign('created_by');
        $table->dropForeign('reviewed_by');
    }
}
