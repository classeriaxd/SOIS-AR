<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $primaryKey = 'level_id';
    protected $table = 'levels';

    public function events()
    {
        return $this->hasMany(Event::class, 'level_id');
    }

    public function studentAccomplishments()
    {
        return $this->hasMany(studentAccomplishments::class, 'level_id');
    }
}
