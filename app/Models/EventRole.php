<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRole extends Model
{
    protected $primaryKey = 'event_role_id';
    protected $table = 'event_roles';

    public function events()
    {
        return $this->hasMany(Event::class, 'event_role_id');
    }
}
