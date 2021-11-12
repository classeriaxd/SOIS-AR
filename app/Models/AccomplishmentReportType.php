<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccomplishmentReportType extends Model
{
    protected $primaryKey = 'accomplishment_report_type_id';
    protected $table = 'accomplishment_report_types';

    public function organization()
    {
        return $this->hasMany(AccomplishmentReport::class, 'accomplishment_report_type_id');
    }
}
