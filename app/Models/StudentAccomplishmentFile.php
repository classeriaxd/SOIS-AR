<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 
class StudentAccomplishmentFile extends Model
{
    use SoftDeletes;

    protected $table = 'student_accomplishment_files';
    protected $primaryKey = 'student_accomplishment_file_id';
    protected $guarded = [];

    public function accomplishment()
    {
        return $this->belongsTo(StudentAccomplishment::class, 'student_accomplishment_id');
    }
    public function documentType()
    {
        return $this->belongsTo(StudentAccomplishmentDocumentType::class, 'SA_document_type_id');
    }
}
