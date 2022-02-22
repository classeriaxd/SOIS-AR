<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SoisGateSeeder extends Seeder
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
                'user_id' => '1',
                'is_logged_in' => '0',
                'gate_key' => 'KfOzrWLQmNFLGN4IbJ4ZRSjz0SaIlPQgIt90wb6E',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('sois_gates')->insert($data);
    }
}
