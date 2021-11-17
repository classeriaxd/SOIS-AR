<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 
class StudentAccomplishmentDocumentType extends Model
{
    use SoftDeletes;

    protected $table = 'SA_document_types';
    protected $primaryKey = 'SA_document_type_id';
    protected $guarded = [];

    public function documents()
    {
        return $this->hasMany(StudentAccomplishmentFile::class, 'SA_document_type_id');
    }
}
