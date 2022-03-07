<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicMembershipReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_receipts', function (Blueprint $table) {
            $table->id('receipt_id');
            $table->unsignedBigInteger('members_id');
            $table->unsignedBigInteger('membership_id');
            $table->string('receipt_number');

            $table->timestamps();

            $table->foreign('membership_id')->references('academic_membership_id')->on('academic_membership')->onDelete('cascade');
            $table->foreign('members_id')->references('academic_member_id')->on('academic_members')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_membership_receipts');
    }
}
