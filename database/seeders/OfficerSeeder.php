<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class OfficerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $term_start = Carbon::parse('First day of October 2021')->format('Y-m-d');
        $term_end = Carbon::parse('Last day of September 2022')->format('Y-m-d');
        $currentTime = Carbon::now();
        $data = [
            [
                // 1
                'position_title_id' => 1,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Juan Carlos',
                'middle_name' => NULL,
                'last_name' => 'Amaguin',
                'suffix' => NULL,
                'signature' => '/organization_assets/signature/sample_signature1/sample_signature1.png',
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            
            [
                // 2
                'position_title_id' => 2,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Sebastian Carlo',
                'middle_name' => 'Olarte',
                'last_name' => 'Cabiades',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            [
                // 3
                'position_title_id' => 3,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Jojemar',
                'middle_name' => 'Peña',
                'last_name' => 'Exala',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            [
                // 4
                'position_title_id' => 4,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Jannielyn',
                'middle_name' => 'Gisulga',
                'last_name' => 'Etin',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            [
                // 5
                'position_title_id' => 5,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Daisylene Suzy',
                'middle_name' => 'Sabando',
                'last_name' => 'Ross',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            [
                // 6
                'position_title_id' => 6,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Victoria Angela Marie',
                'middle_name' => 'Aquino',
                'last_name' => 'Dolor',
                'suffix' => NULL,
                'signature' => '/organization_assets/signature/sample_signature2/sample_signature2.png',
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
  
            [
                // 7
                'position_title_id' => 7,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Bryant Paul',
                'middle_name' => 'Sana',
                'last_name' => 'Babac',
                'suffix' => NULL,
                'signature' => '/organization_assets/signature/sample_signature3/sample_signature3.png',
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
 
            [
                // 8
                'position_title_id' => 8,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Ian Angelo',
                'middle_name' => 'Parco',
                'last_name' => 'Nierva',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
  
            [
                // 9
                'position_title_id' => 9,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Michelle Via',
                'middle_name' => 'Arcangel',
                'last_name' => 'Rediga',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
 
            [
                // 10
                'position_title_id' => 10,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Rysha Laine',
                'middle_name' => NULL,
                'last_name' => 'Taganas',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
 
            [
                // 11
                'position_title_id' => 11,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Joymee',
                'middle_name' => 'Galido',
                'last_name' => 'Dionisio',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
   
            [
                // 12
                'position_title_id' => 12,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Ray',
                'middle_name' => 'Candare',
                'last_name' => 'Paduano',
                'suffix' => 'Jr.',
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
   
            [
                // 13
                'position_title_id' => 13,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Arvine Justine',
                'middle_name' => 'Hernandez',
                'last_name' => 'Dimaano',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
  
            [
                // 14
                'position_title_id' => 14,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'John Reign',
                'middle_name' => 'Moral',
                'last_name' => 'Encina',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
  
            [
                // 15
                'position_title_id' => 15,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Crissa Mae',
                'middle_name' => 'Boridor',
                'last_name' => 'Galopo',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
  
            [
                // 16
                'position_title_id' => 16,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Janise Hop',
                'middle_name' => 'Del Valle',
                'last_name' => 'Sandigan',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
 
            [
                // 17
                'position_title_id' => 17,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Frances Anne',
                'middle_name' => 'Tinio',
                'last_name' => 'Cruz',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
  
            [
                // 18
                'position_title_id' => 18,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Jonathan',
                'middle_name' => 'Amorado',
                'last_name' => 'Amoranto',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            [
                // 19
                'position_title_id' => 19,
                'term_start' => $term_start,
                'term_end' => $term_end,
                'first_name' => 'Mike Vincent',
                'middle_name' => 'Lidasan',
                'last_name' => 'Ramos',
                'suffix' => NULL,
                'signature' => NULL,
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('officers')->insert($data);
    }
}
