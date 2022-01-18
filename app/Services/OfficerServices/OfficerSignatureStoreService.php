<?php

namespace App\Services\OfficerServices;

use App\Models\Officer;
use App\Models\TemporaryFile;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class OfficerSignatureStoreService
{
    /**
     * @param Request $request, Collection $officer
     * Service to Store/Update an Officer's Signature.
     * Returns Message on success.
     * @return Array
     */
    public function store($request, $officer): array
    {
        try
        {
            $tempPath = '/public/uploads/tmp/';
            $finalPath = '/public/organization_assets/signature/';
            $dbPath = '/organization_assets/signature/';

            if($request->has('signature'))
            {
                // Get File details from TemporaryFile Table
                $file = TemporaryFile::where('folder', $request->input('signature'))->value('filename');
                // Move file to permanent Storage folder
                Storage::move($tempPath . $request->input('signature') . '/' . $file, $finalPath . $file);
                // Delete the directory of temporary file
                $this->deleteDirectory($tempPath . $request->input('signature'));
                // Delete entry on TemporaryFile Table
                TemporaryFile::where('folder', $request->input('signature'))->delete();

                // If Officer has no Signature...
                if ($officer->signature !== NULL) 
                {
                    $this->deleteDirectory(Str::of('/public' . $officer->signature)->dirname());
                }

                // Create EventDocument entry
                Officer::where('officer_id', $officer->officer_id)
                    ->update([
                        'signature' => $dbPath . $file,
                ]);
            }

            $returnArray = array('success' => 'Officer Signature updated successfully!');

            return $returnArray;
        }
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array('error' => 'Error in Updating Officer Signature:' . $e->getMessage());

            return $returnArray;
        }
        
    }

    /**
     * @param String $folderPath
     * Private Function to delete temporary directories.
     * @return void
     */
    private function deleteDirectory($folderPath)
    {
        Storage::deleteDirectory($folderPath, true);
        sleep(0.3);
        Storage::deleteDirectory($folderPath);
    }
}
