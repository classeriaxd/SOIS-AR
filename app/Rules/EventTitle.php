<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use \App\Models\Event;

class EventTitle implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($event_slug)
    {
        $this->event_slug = $event_slug;
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
        $old_title = Event::where('slug', $this->event_slug)->value('title');
        return ((Event::where('title', $value)->doesntExist()) || 
            ((Event::where('title', $old_title)->value('title')) == $value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Title must be unique or same as old Title';
    }
}
