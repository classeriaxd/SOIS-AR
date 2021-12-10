<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabularTable extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $primaryKey = 'tabular_table_id';
    protected $table = 'tabular_tables';
    
    public function tabularColumns()
    {
    	return $this->hasMany(TabularColumn::class, 'tabular_table_id');
    }
}
