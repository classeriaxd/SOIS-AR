<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationDocument extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $primaryKey = 'organization_document_id';
    protected $table = 'organization_documents';

    public function documentType()
    {
        return $this->belongsTo(OrganizationDocumentType::class, 'organization_document_type_id');
    }
}
