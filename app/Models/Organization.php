<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'organization_id';
    protected $table = 'organizations';
    protected $logo_id = 1;

    public function events()
    {
    	return $this->hasMany(Event::class, 'organization_id');
    }

    public function courses()
    {
        return $this->hasMany(Courses::class, 'organization_id');
    }

    public function compiledDocuments()
    {
        return $this->hasMany(CompiledDocuments::class, 'organization_id');
    }

    public function assets()
    {
        return $this->hasMany(OrganizationAsset::class, 'organization_id');
    }

    public function asset()
    {
        return $this->hasOne(OrganizationAsset::class, 'organization_id');
    }

    public function logo()
    {
        return $this->hasOne(OrganizationAsset::class, 'organization_id')->where('organization_asset_type_id', $this->logo_id)->limit(1);
    }
    public function logos()
    {
        return $this->hasMany(OrganizationAsset::class, 'organization_id')->where('organization_asset_type_id', $this->logo_id)->limit(1);
    }
}
