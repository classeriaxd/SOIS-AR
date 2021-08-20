<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAccomplishmentFile extends Model
{

    protected $table = 'student_accomplishment_files';
    protected $primaryKey = 'student_accomplishment_file_id';
    protected $guarded = [];

    public function accomplishment()
    {
        return $this->belongsTo(StudentAccomplishment::class, 'student_accomplishment_id');
    }
}
