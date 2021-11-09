<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationAssetType extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'organization_asset_type_id';
    protected $table = 'organization_asset_types';
    
    public function assets()
    {
        return $this->hasMany(OrganizationAsset::class, 'organization_asset_type_id');
    }

}
