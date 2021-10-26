<?php

namespace App\Services\Admin\EventMaintenance\EventDocumentType;

use App\Models\EventDocumentType;
use Illuminate\Support\Str;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventDocumentTypeUpdateService
{
    /**
     * @param Collection $documentType, Request $request
     * Service to Update an Event Document Type.
     * Returns Message on success
     * @return Array
     */
    public function update(EventDocumentType $documentType, $request): array
    {
        try 
        {
            $documentType->update([
                'document_type' => $request->input('documentType'),
                'helper' => $request->input('helper', NULL),
            ]);
            
            // Notify All Documentation Officers
            if ($request->has('notify')) 
            {
                $adminNotificationService = new AdminNotificationService();
                $adminNotificationService->sendNotification(
                    'All', 
                    'SYSTEM: Update on Event Document Type',
                    'The Administrator has made changes to an Event Document Type (' . $documentType->document_type . '). Go to Event Document Creation Page to view changes.',
                    1,
                );
            }

            return ['success' => 'Updated the Event Document Type Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Updating Event Document Type:' . $e->getMessage()];
        }
            
    }
}
