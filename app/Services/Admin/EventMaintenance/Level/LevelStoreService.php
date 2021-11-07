<?php

namespace App\Services\Admin\EventMaintenance\Level;

use App\Models\Level;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class LevelStoreService
{
    /**
     * @param Request $request
     * Service to Store a Level.
     * Returns Message on success
     * @return Array
     */
    public function store($request): array
    {
        try 
        {
            $level = Level::create([
                'level' => $request->input('level'),
                'helper' => $request->input('helper', NULL),
            ]);

            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                'SYSTEM: Added a Level',
                'The Administrator has added a new Level (' . $level->level . '). Go to Event Creation Page to view it.',
                1,
            );
                
            return ['success' => 'Added the Level Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in adding Level:' . $e->getMessage()];
        }
    }
}
