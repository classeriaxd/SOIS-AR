<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FundSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['fund_source' => 'University Funded',
                'helper' => 'The Event was funded by the university.',
            ],
            ['fund_source' => 'Self Funded',
                'helper' => 'The Event was funded by the organizer.',
            ],
            ['fund_source' => 'Externally Funded',
                'helper' => 'The Event was funded by other sponsors.',
            ],
            ['fund_source' => 'No Funding Required',
                'helper' => 'The Event did not require any funding.',
            ],
        ];
        DB::table('fund_sources')->insert($data);
    }
}
