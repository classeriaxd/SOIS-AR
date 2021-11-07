<?php

namespace App\Services\Admin\EventMaintenance\EventCategory;

use App\Models\EventCategory;
use Illuminate\Support\Str;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventCategoryStoreService
{
    /**
     * @param Request $request
     * Service to Store an Event Category.
     * Returns Message on success
     * @return Array
     */
    public function store($request): array
    {
        try 
        {
            $eventCategory = EventCategory::create([
                'category' => $request->input('category'),
                'helper' => $request->input('helper', NULL),
                'background_color' => Str::upper($request->input('background_color', '#0376FF')),
                'text_color' => Str::upper($request->input('text_color', '#FFFFFF')),
            ]);

            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                'SYSTEM: Added an Event Category',
                'The Administrator has added a new Event Category (' . $eventCategory->category . '). Go to Event Creation Page to view it.',
                1,
            );
                
            return ['success' => 'Added the Event Category Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in adding Event Category:' . $e->getMessage()];
        }
    }
}
