<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentAccomplishmentDocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['document_type' => 'Certificate of Participation',
                'helper' => 'A document that certifies that the student attended the event.',
            ],
            ['document_type' => 'Screenshot',
                'helper' => 'Screenshot of the event.',
            ],
            ['document_type' => 'Photograph',
                'helper' => 'Photograph of the event.',
            ],
            ['document_type' => 'Narrative Report',
                'helper' => 'A document containing the Narration of the actual Event.',
            ],
            ['document_type' => 'Event Attendance Sheet',
                'helper' => 'A document containing the list of people who attended the Event.',
            ],
            ['document_type' => 'Event Evaluation',
                'helper' => 'A document containing the Evaluation Result of the Event.',
            ],
        ];
        DB::table('SA_document_types')->insert($data);
    }
}
