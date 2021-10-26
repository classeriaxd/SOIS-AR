<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundSource extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $primaryKey = 'fund_source_id';
    protected $table = 'fund_sources';

    public function events()
    {
        return $this->hasMany(Event::class, 'fund_source_id');
    }
}
