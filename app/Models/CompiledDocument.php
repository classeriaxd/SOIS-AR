<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompiledDocument extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $primaryKey = 'compiled_document_id';
    protected $table = 'compiled_documents';

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
