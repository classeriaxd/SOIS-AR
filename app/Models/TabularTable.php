<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TabularTable extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'tabular_table_id';
    protected $table = 'tabular_tables';
    
    public function tabularColumns()
    {
    	return $this->hasMany(TabularColumn::class, 'tabular_table_id');
    }
}
