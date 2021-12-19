<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_years', function (Blueprint $table) {
            $table->id('school_year_id');
            $table->year('year_start')->unique();
            $table->year('year_end')->unique();
            $table->date('annual_start')->nullable();
            $table->date('annual_end')->nullable();
            $table->date('first_semester_start')->nullable();
            $table->date('first_semester_end')->nullable();
            $table->date('second_semester_start')->nullable();
            $table->date('second_semester_end')->nullable();
            $table->date('summer_term_start')->nullable();
            $table->date('summer_term_end')->nullable();
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
        Schema::dropIfExists('school_years');
    }
}
