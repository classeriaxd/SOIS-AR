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
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'user_id');
    }
    public function event()
    {
        return $this->belongsTo(Event::class, 'accomplished_event_id');
    }
    public function fundSource()
    {
        return $this->belongsTo(FundSource::class, 'fund_source_id');
    }
}
