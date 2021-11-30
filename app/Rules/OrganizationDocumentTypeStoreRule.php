<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Models\Organization;
use App\Models\OrganizationDocumentType;

class OrganizationDocumentTypeStoreRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($organizationSlug)
    {
        $this->organizationSlug = $organizationSlug;
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
        $organizationID = Organization::where('organization_slug', $this->organizationSlug)->value('organization_id');
        $organizationDocumentTypes = OrganizationDocumentType::where('organization_id', $organizationID)->pluck('type');

        return ($organizationDocumentTypes->search($value) !== false) ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Document Type must be unique.';
    }
}
