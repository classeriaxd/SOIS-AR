<?php

namespace App\Services\Admin\EventMaintenance\EventClassification;

use App\Models\EventClassification;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventClassificationUpdateService
{
    /**
     * @param Collection $classification, Request $request
     * Service to Update an Event Classification.
     * Returns Message on success
     * @return Array
     */
    public function update(EventClassification $classification, $request)
    {
        try 
        {
            $classification->update([
                'classification' => $request->input('classification'),
                'helper' => $request->input('helper', NULL),
            ]);
            
            // Notify All Documentation Officers
            if ($request->has('notify')) 
            {
                $adminNotificationService = new AdminNotificationService();
                $adminNotificationService->sendNotification(
                    'All', 
                    'SYSTEM: Update on Event Classification',
                    'The Administrator has made changes to an Event Classification (' . $classification->classification . '). Go to Event Creation Page to view changes.',
                    1,
                );
            }

            return ['success' => 'Updated the Event Classification Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Updating Event Classification:' . $e->getMessage()];
        }
            
    }
}
