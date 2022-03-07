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
                'organization_id' => 3,
                'type' => 'Constitution',
                'slug' => 'constitutions',
            ],

            [
                'organization_id' => 3,
                'type' => 'Resolution',
                'slug' => 'resolutions',
            ],

            [
                'organization_id' => 3,
                'type' => 'Memorandum Order',
                'slug' => 'memorandum_orders',
            ],
            
        ];
        DB::table('organization_document_types')->insert($data);
    }
}
