<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\Organization;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orgs = Organization::all();

        foreach($orgs as $org)
        {
            Event::factory()
                ->for($org)
                ->has(EventImage::factory()->count(4))
                ->count(20)
                ->create();
        }
        
    }
}
