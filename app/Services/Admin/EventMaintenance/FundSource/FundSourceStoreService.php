<?php

namespace App\Services\Admin\EventMaintenance\FundSource;

use App\Models\FundSource;
use Illuminate\Support\Str;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class FundSourceStoreService
{
    /**
     * @param Request $request
     * Service to Store a Fund Source.
     * Returns Message on success
     * @return Array
     */
    public function store($request): array
    {
        try 
        {
            $fundSource = FundSource::create([
                'fund_source' => $request->input('fundSource'),
                'helper' => $request->input('helper', NULL),
            ]);

            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                'SYSTEM: Added a Fund Source',
                'The Administrator has added a new Fund Source (' . $fundSource->fund_source . '). Go to Event Creation Page to view it.',
                1,
            );
                
            return ['success' => 'Added the Fund Source Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in adding Fund Source:' . $e->getMessage()];
        }
    }
}
