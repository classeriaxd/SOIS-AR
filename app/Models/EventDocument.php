<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventDocument extends Model
{
    use SoftDeletes;
    protected $guarded = [];
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
