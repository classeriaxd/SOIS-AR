<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationDocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'organization_id' => 2,
                'type' => 'Constitution',
            ],

            [
                'organization_id' => 2,
                'type' => 'Resolution',
            ],

            [
                'organization_id' => 2,
                'type' => 'Memorandum Order',
            ],
            
        ];
        DB::table('organization_document_types')->insert($data);
    }
}
