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
            ['document_type' => 'Notice of the Meeting',
                'helper' => 'A document containing the Announcement of the Meeting for the Event.',
            ],
            ['document_type' => 'Minutes of the Meeting',
                'helper' => 'A document containing the notes and plans discussed in the Meeting for the Planning of an Event.',
            ],
            ['document_type' => 'Program Flow',
                'helper' => 'A document containing the Invitation Program of the Event.',
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
            ['document_type' => 'MOA',
                'helper' => 'Memorandum of Agreement',
            ],
            ['document_type' => 'MOU',
                'helper' => 'MOU',
            ],
            ['document_type' => 'Certificate of Recognition',
                'helper' => 'Certificate of Recognition',
            ],
            ['document_type' => 'Certificate of Appreciation',
                'helper' => 'Certificate of Appreciation',
            ],


        ];
        DB::table('event_document_types')->insert($data);
    }
}
