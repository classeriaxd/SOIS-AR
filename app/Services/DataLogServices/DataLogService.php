<?php

namespace App\Services\DataLogServices;

use App\Models\DataLog;

class DataLogService
{
    /**
     * @param Integer $userID, String $details
     * Service to Store a data log.
     */
    public function log($userID, $details)
    {
        DataLog::create([
            'user_id' => $userID,
            'details' => $details,
        ]);
    }
}
