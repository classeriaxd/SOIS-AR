<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventClassification extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    protected $primaryKey = 'event_classification_id';
    protected $table = 'event_classifications';

    public function events()
    {
        return $this->hasMany(Event::class, 'event_classification_id');
    }
}
