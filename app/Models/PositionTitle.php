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

    public function positionCategory()
    {
        return $this->belongsTo(PositionCategory::class, 'position_category_id');
    }

    public function officers()
    {
        return $this->hasMany(Officer::class, 'position_title_id')->orderBy('position_title_id');
    }
}
