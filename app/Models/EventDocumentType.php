<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDocumentType extends Model
{
    protected $primaryKey = 'event_document_type_id';
    protected $table = 'event_document_types';

    public function document()
    {
        return $this->hasMany(EventDocument::class, 'event_document_type_id');
    }
}
