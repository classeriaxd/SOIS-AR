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
        return $this->hasMany(StudentAccomplishmentFile::class, 'student_accomplishment_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
