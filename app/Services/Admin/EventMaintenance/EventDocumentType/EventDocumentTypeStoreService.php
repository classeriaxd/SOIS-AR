<?php

namespace App\Services\Admin\EventMaintenance\EventDocumentType;

use App\Models\EventDocumentType;
use Illuminate\Support\Str;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventDocumentTypeStoreService
{
    /**
     * @param Request $request
     * Service to Store an Event Document Type.
     * Returns Message on success
     * @return Array
     */
    public function store($request): array
    {
        try 
        {
            $eventDocumentType = EventDocumentType::create([
                'document_type' => $request->input('documentType'),
                'helper' => $request->input('helper', NULL),
            ]);

            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                'SYSTEM: Added an Event Document Type',
                'The Administrator has added a new  Document Type (' . $eventDocumentType->document_type . '). Go to Event Document Creation Page to view it.',
                1,
            );
                
            return ['success' => 'Added the Event Document Type Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in adding Event Document Type:' . $e->getMessage()];
        }
    }
}
