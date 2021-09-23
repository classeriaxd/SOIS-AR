<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
