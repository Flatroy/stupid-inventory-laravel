<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        // parent - null or randim Location
        $parent = null;
        if ($this->faker->boolean()) {
            $parent = Location::inRandomOrder()?->first() ?? Location::factory()->create();
        }

        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'parent_id' => $parent?->id,
            'is_active' => $this->faker->boolean(),
            'team_id' => Team::first()?->id ?? Team::factory()->create()->id,
        ];
    }
}
