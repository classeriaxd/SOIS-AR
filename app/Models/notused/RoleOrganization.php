<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleOrganization extends Pivot
{
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'organization_id');
    }
}
