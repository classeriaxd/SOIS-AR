<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FundSourceSeeder extends Seeder
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
            ['fund_source' => 'University Funded',
                'helper' => 'The Event was funded by the university.',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['fund_source' => 'Self Funded',
                'helper' => 'The Event was funded by the organizer.',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['fund_source' => 'Externally Funded',
                'helper' => 'The Event was funded by other sponsors.',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['fund_source' => 'No Funding Required',
                'helper' => 'The Event did not require any funding.',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('fund_sources')->insert($data);
    }
}
