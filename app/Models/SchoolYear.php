<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'school_year_id';
    protected $table = 'school_years';
}
