<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionTitle extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'position_title_id';
    protected $table = 'position_titles';

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_position_titles');
    }
}
