<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use \App\Models\TabularColumn;

class TabularColumnNameUpdateRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($tabular_table_id, $tabular_column_id)
    {
        $this->tabular_table_id = $tabular_table_id;
        $this->tabular_column_id = $tabular_column_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     * same or unique
     */
    public function passes($attribute, $value)
    {
        $tabularColumns = TabularColumn::where('tabular_table_id', $this->tabular_table_id)->pluck('tabular_column_name');
        $currentTabularColumnName = TabularColumn::where('tabular_column_id', $this->tabular_column_id)->value('tabular_column_name');
        $tabularColumns->forget($tabularColumns->search($currentTabularColumnName));

        return (($currentTabularColumnName === $value) || (($tabularColumns->search($value) === false) ? true : false));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Column Name must be same as Current Column Name or is unique to the table.';
    }
}
