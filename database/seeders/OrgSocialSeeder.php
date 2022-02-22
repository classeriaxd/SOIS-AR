<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrgSocialSeeder extends Seeder
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
                'org_socials_id' => 1,
                'organization_id' => 1,
                'social_id' => '1',
                'org_social_link' => 'https://www.facebook.com/PUPTOFFICIAL',
                'status' => '1',
                'embed_data' => '<div class="fb-post" data-href="https://www.facebook.com/PUPTOFFICIAL" data-width="500" data-show-text="true"></div>',
                'social_name' => 'Facebook',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'org_socials_id' => 2,
                'organization_id' => 1,
                'social_id' => '1',
                'org_social_link' => 'https://www.facebook.com/PUPTOFFICIAL',
                'status' => '1',
                'embed_data' => '<a class="twitter-timeline" data-width="500" data-theme="dark" href="https://twitter.com/ThePUPOfficial?ref_src=twsrc%5Etfw">Tweets by ThePUPOfficial</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>',
                'social_name' => 'Facebook',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('org_socials')->insert($data);
    }
}
