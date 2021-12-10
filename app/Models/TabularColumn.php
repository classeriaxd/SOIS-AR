<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabularColumn extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $primaryKey = 'tabular_column_id';
    protected $table = 'tabular_columns';

    public function tabularTable()
    {
        return $this->belongsTo(TabularTable::class, 'tabular_table_id');
    }
}
