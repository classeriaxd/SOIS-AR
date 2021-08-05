<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use Str;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->unique()->sentence($nbWords = 4, $variableNbWords = true);
        $title = Str::remove('.', $title);
        $date = $this->faker->dateTimeBetween($startDate = '-4 years', $endDate = 'now', $timezone = null);
        $slug = Str::replace(' ', '-', $title).'-'.Carbon::parse($date)->format('Y');
        return [
            'title' => $title,
            'description' => $this->faker->paragraph($nbSentences = 4, $variableNbSentences = true),
            'objective' => $this->faker->paragraph($nbSentences = 4, $variableNbSentences = true),
            'date' => $date,
            'start_time' => $this->faker->dateTimeBetween($startDate = '00:00:00', $endDate = '12:00:00', $timezone = null),
            'end_time' => $this->faker->dateTimeBetween($startDate = '12:01:00', $endDate = '23:59:00', $timezone = null),
            'venue' => $this->faker->address(),
            'activity_type' => 'Educational',
            'beneficiaries' => 'PUP Students',
            'sponsors' => $this->faker->company(),
            'budget' => $this->faker->numberBetween($min = 1000, $max = 10000),
            'slug' => $slug,
        ];
    }
}
