<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use \App\Models\TabularColumn;

class TabularColumnNameStoreRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($tabular_table_id)
    {
        $this->tabular_table_id = $tabular_table_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $tabularColumns = TabularColumn::where('tabular_table_id', $this->tabular_table_id)->pluck('tabular_column_name');
        
        return ($tabularColumns->search($value) !== false) ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Column Name must be unique.';
    }
}
