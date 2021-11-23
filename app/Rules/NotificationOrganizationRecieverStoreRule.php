<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use \App\Models\Organization;

class NotificationOrganizationRecieverStoreRule implements Rule
{
    

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $organizationExists = false;
        foreach ($value as $organization) 
        {
            if (Organization::where('organization_id', $organization)->exists())
                $organizationExists = true;
            else
            {
                $organizationExists = false;
                break;
            }

        }
        
        return ($organizationExists);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Organization';
    }
}
