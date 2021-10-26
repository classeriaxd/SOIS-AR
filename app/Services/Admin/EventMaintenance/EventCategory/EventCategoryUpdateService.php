<?php

namespace App\Services\Admin\EventMaintenance\EventCategory;

use App\Models\EventCategory;
use Illuminate\Support\Str;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventCategoryUpdateService
{
    /**
     * @param Collection $category, Request $request
     * Service to Update an Event Category.
     * Returns Message on success
     * @return Array
     */
    public function update(EventCategory $category, $request): array
    {
        try 
        {
            $category->update([
                'category' => $request->input('category'),
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
                    'SYSTEM: Update on Event Category',
                    'The Administrator has made changes to an Event Category (' . $category->category . '). Go to Event Creation Page to view changes.',
                    1,
                );
            }

            return ['success' => 'Updated the Event Category Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Updating Event Category:' . $e->getMessage()];
        }
            
    }
}
