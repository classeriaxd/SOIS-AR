<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccomplishmentReportAlt extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $primaryKey = 'accomplishment_report_alt_id';
    protected $table = 'accomplishment_reports_alt';

    public function accomplishmentReport()
    {
        return $this->belongsTo(AccomplishmentReport::class, 'accomplishment_report_id');
    }

}
