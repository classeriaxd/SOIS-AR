<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'organization_asset_id';
    protected $table = 'organization_assets';
    
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

}
