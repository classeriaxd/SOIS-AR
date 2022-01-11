<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataLog extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'data_log_id';
    protected $table = 'ar_data_logs';
    
    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
