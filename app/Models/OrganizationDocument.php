<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationDocument extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $primaryKey = 'org_id';
    protected $table = 'organization_documents';
    

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
    public function documentType()
    {
        return $this->belongsTo(OrganizationDocumentType::class, 'orgdoctype_id');
    }
}
