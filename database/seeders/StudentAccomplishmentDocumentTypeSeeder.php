<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class StudentAccomplishmentDocumentTypeSeeder extends Seeder
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
                'document_type' => 'Certificate of Participation',
                'helper' => 'A document that certifies that the student attended the event.',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'document_type' => 'Screenshot',
                'helper' => 'Screenshot of the event.',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'document_type' => 'Photograph',
                'helper' => 'Photograph of the event.',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('SA_document_types')->insert($data);
    }
}
