<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundSource extends Model
{
    protected $primaryKey = 'fund_source_id';
    protected $table = 'fund_sources';

    public function events()
    {
        return $this->hasMany(Event::class, 'fund_source_id');
    }
}
