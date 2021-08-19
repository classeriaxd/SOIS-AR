<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemporaryFile extends Model
{
    protected $fillable = ['folder', 'filename'];
    protected $table = 'temporary_files';
}
