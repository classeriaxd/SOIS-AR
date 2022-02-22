<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SoisLinkSeeder extends Seeder
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
            [
                'sois_links_id' => 1,
                'link_name' => 'Accomplishment Report',
                'link_description' => 'This link is to access Accomplishment Reports website',
                'external_link' => 'https://sois-ar.puptaguigcs.net/',
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'sois_links_id' => 2,
                'link_name' => 'GPOA',
                'link_description' => 'This link is to access GPOA website',
                'external_link' => 'http://sois-gpoa.puptaguigcs.net/',
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'sois_links_id' => 3,
                'link_name' => 'Membership',
                'link_description' => 'This link is to access Membership website',
                'external_link' => 'https://sois-membership.puptaguigcs.net/',
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('sois_links')->insert($data);
    }
}
