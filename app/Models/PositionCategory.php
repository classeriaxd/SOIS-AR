<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionCategory extends Model
{
    protected $primaryKey = 'position_category_id';
    protected $table = 'position_categories';

    public function positionTitles()
    {
        return $this->hasMany(PositionTitle::class, 'position_category_id');
    }
}
