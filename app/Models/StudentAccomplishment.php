<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAccomplishment extends Model
{
    protected $table = 'student_accomplishments';
    protected $primaryKey = 'student_accomplishment_id';
    protected $guarded = [];

    public function accomplishmentFiles()
    {
        return $this->hasMany(StudentAccomplishmentFile::class, 'student_accomplishments_id');
    }
}
