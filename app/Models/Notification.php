<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'notification_id';
    protected $table = 'notifications';
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
