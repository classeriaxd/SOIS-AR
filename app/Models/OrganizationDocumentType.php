<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationDocumentType extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'organization_document_types';
    protected $primaryKey = 'organization_document_type_id';

    public function organizationDocuments()
    {
        return $this->hasMany(OrganizationDocument::class, 'organization_document_type_id');
    }
    public function organizationDocumentsForDisplay()
    {
        return $this->hasMany(OrganizationDocument::class, 'organization_document_type_id')->limit(3);
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
