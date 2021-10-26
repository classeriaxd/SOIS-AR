<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currentTime = Carbon::now();
        $data = [
            ['level' => 'Institutional',
                'helper' => 'The Beneficiaries/Participants of the event were from PUP-Taguig only.',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['level' => 'Local',
                'helper' => 'The Beneficiaries/Participants of the event were from not only PUP-Taguig but within Taguig City and other nearby Municipality.',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['level' => 'Regional',
                'helper' => 'The Beneficiaries/Participants of the Event were from different parts of the NCR Region.',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['level' => 'National',
                'helper' => 'The Beneficiaries/Participants of the event were from all over the Philippines.',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['level' => 'International',
                'helper' => 'The Beneficiaries/Participants of the event were from all over the world.',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('levels')->insert($data);
    }
}
