<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'team_id' => Team::first()?->id ?? Team::factory()->create()->id,
        ];
    }
}
