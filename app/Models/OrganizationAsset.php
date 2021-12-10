<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationAsset extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'organization_asset_id';
    protected $table = 'organization_assets';
    
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function assetType()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id');
    }

}
