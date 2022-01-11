<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DataLog extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'data_log_id';
    protected $table = 'ar_data_logs';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['elapsed_time'];
    
    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Compute the Elapsed Time of a data log.
     * @return string
     */
    public function getElapsedTimeAttribute()
    {
        $elapsedTime = Carbon::parse($this->created_at)->diffForHumans(['parts' => 2]);
        return $elapsedTime;
    }
}
