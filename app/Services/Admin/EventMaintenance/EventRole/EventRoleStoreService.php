<?php

namespace App\Services\Admin\EventMaintenance\EventRole;

use App\Models\EventRole;
use Illuminate\Support\Str;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventRoleStoreService
{
    /**
     * @param Request $request
     * Service to Store an Event Role.
     * Returns Message on success
     * @return Array
     */
    public function store($request)
    {
        try 
        {
            $eventRole = EventRole::create([
                'event_role' => $request->input('role'),
                'helper' => $request->input('helper', NULL),
                'background_color' => Str::upper($request->input('background_color', '#0376FF')),
                'text_color' => Str::upper($request->input('text_color', '#FFFFFF')),
            ]);

            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                'SYSTEM: Added an Event Role',
                'The Administrator has added a new Event Role (' . $eventRole->event_role . '). Go to Event Creation Page to view it.',
                1,
            );
                
            return ['success' => 'Added the Event Role Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in adding Event Role:' . $e->getMessage()];
        }
    }
}
