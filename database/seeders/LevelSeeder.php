<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['level' => 'Institutional',
                'helper' => 'The Beneficiaries/Participants of the event were from PUP-Taguig only.',
            ],
            ['level' => 'Local',
                'helper' => 'The Beneficiaries/Participants of the event were from not only PUP-Taguig but within Taguig City and other nearby Municipality.',
            ],
            ['level' => 'Regional',
                'helper' => 'The Beneficiaries/Participants of the Event were from different parts of the NCR Region.',
            ],
            ['level' => 'National',
                'helper' => 'The Beneficiaries/Participants of the event were from all over the Philippines.',
            ],
            ['level' => 'International',
                'helper' => 'The Beneficiaries/Participants of the event were from all over the world.',
            ],
        ];
        DB::table('levels')->insert($data);
    }
}
