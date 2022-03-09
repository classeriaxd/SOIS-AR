<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SOISGate extends Model
{
    protected $fillable = ['gate_key', 'updated_at'];
    protected $primaryKey = 'sois_gates_id';
    protected $table = 'sois_gates';
}
