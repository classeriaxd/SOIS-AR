<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccomplishmentReportTypeSeeder extends Seeder
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
                'accomplishment_report_type' => 'Tabular',
            ],
            [
                'accomplishment_report_type' => 'Design',
            ],
        ];
        DB::table('accomplishment_report_types')->insert($data);
    }
}
