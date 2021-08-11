<?php

namespace Database\Factories;

use App\Models\EventImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class EventImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $image = $this->faker->image($dir = 'public/storage/seeds', 640, 480, 'eventimage');
        $image = Str::remove('public/storage', $image); 
        $image = Str::replace('\\', '/', $image); 
        return [
            'image_type' => $this->faker->randomElement($array = array('0','1')),
            'image' => $image,
            'caption' => $this->faker->realText($maxNbChars = 40, $indexSize = 1),
            'slug' => $this->faker->unique()->uuid(),
        ];
    }
}
