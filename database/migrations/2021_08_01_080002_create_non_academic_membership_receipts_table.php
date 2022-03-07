<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonAcademicMembershipReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_academic_receipts', function (Blueprint $table) {
            $table->id('receipt_id');
            $table->unsignedBigInteger('members_id');
            $table->unsignedBigInteger('membership_id');
            $table->string('receipt_number');

            $table->timestamps();

            $table->foreign('membership_id')->references('non_academic_membership_id')->on('non_academic_membership')->onDelete('cascade');
            $table->foreign('members_id')->references('non_academic_member_id')->on('non_academic_members')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('non_academic_membership_receipts');
    }
}
