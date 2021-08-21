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
                'org_id' => '1',
                'doctype' => 'Minutes of the Meeting',
            ],

            [
                'org_id' => '1',
                'doctype' => 'Constitution',
            ],

            [
                'org_id' => '1',
                'doctype' => 'Resolution',
            ],

            [
                'org_id' => '1',
                'doctype' => 'Memorandum Order',
            ],

            [
                'org_id' => '2',
                'doctype' => 'Minutes of the Meeting',
            ],

            [
                'org_id' => '2',
                'doctype' => 'Constitution',
            ],

            [
                'org_id' => '2',
                'doctype' => 'Resolution',
            ],

            [
                'org_id' => '2',
                'doctype' => 'Memorandum Order',
            ],
            
        ];
        DB::table('organization_document_types')->insert($data);
    }
}
