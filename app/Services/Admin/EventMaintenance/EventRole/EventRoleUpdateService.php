<?php

namespace App\Services\Admin\EventMaintenance\EventRole;

use App\Models\EventRole;
use Illuminate\Support\Str;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventRoleUpdateService
{
    /**
     * @param Request $request
     * Service to Update an Event Category.
     * Returns Message on success
     * @return Array
     */
    public function update(EventRole $role, $request)
    {
        try 
        {
            $role->update([
                'event_role' => $request->input('role'),
                'helper' => $request->input('helper', NULL),
                'background_color' => Str::upper($request->input('background_color', '#0376FF')),
                'text_color' => Str::upper($request->input('text_color', '#FFFFFF')),
            ]);
            
            // Notify All Documentation Officers
            if ($request->has('notify')) 
            {
                $adminNotificationService = new AdminNotificationService();
                $adminNotificationService->sendNotification(
                    'All', 
                    'SYSTEM: Update on Event Role',
                    'The Administrator has made changes to an Event Role (' . $role->event_role . '). Go to Event Creation Page to view changes.',
                    1,
                );
            }

            return ['success' => 'Updated the Event Role Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Updating Event Role:' . $e->getMessage()];
        }
            
    }
}
