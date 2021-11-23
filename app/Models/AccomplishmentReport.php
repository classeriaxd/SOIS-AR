<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class AccomplishmentReport extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $primaryKey = 'accomplishment_report_id';
    protected $table = 'accomplishment_reports';

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function accomplishmentReportType()
    {
        return $this->belongsTo(AccomplishmentReportType::class, 'accomplishment_report_type_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'user_id');
    }
}
