<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventDocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['document_type' => 'Notice of the Meeting',],
            ['document_type' => 'Minutes of the Meeting',],
            ['document_type' => 'Event Attendance Sheet',],
            ['document_type' => 'Event Evaluation',],
        ];
        DB::table('event_document_types')->insert($data);
    }
}
