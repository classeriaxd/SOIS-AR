<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Models\Organization;
use App\Models\OrganizationDocumentType;

class OrganizationDocumentTypeUpdateRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($organizationSlug, $organizationDocumentTypeSlug)
    {
        $this->organizationSlug = $organizationSlug;
        $this->organizationDocumentTypeSlug = $organizationDocumentTypeSlug;
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
        $organizationID = Organization::where('organization_slug', $this->organizationSlug)->value('organization_id');
        $organizationDocumentTypes = OrganizationDocumentType::where('organization_id', $organizationID)->pluck('type');
        $currentOrganizationDocumentType = OrganizationDocumentType::where('organization_id', $organizationID)->where('slug', $this->organizationDocumentTypeSlug)->value('type');

        $organizationDocumentTypes->forget($organizationDocumentTypes->search($currentOrganizationDocumentType));

        return (($currentOrganizationDocumentType === $value) || (($organizationDocumentTypes->search($value) === false) ? true : false));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Organization Document Type must be same as current or is unique to the table.';
    }
}
