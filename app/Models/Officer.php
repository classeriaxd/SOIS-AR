<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'officer_id';
    protected $table = 'officers';
    protected $appends = ['full_name'];

    public function positionTitle()
    {
        return $this->belongsTo(PositionTitle::class, 'position_title_id');
    }
    
    /**
     * Get the user's full concatenated name.
     * @return string
     */
    public function getFullNameAttribute()
    {
        $name = "{$this->last_name}, {$this->first_name}";

        if (! $this->middle_name === NULL)
            $name .= " {$this->middle_name}";
        if (! $this->suffix === NULL)
            $name .= " {$this->suffix}";

        return $name;
    }
}
