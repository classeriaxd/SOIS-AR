<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDocument extends Model
{
    protected $primaryKey = 'event_document_id';
    protected $table = 'event_documents';

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function documentType()
    {
        return $this->belongsTo(EventDocumentType::class, 'event_document_type_id');
    }
}
