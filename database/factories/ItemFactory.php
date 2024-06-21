<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Location;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'ulid' => $this->faker->words(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'import_ref' => $this->faker->word(),
            'notes' => $this->faker->word(),
            'quantity' => $this->faker->randomNumber(3),
            'insured' => $this->faker->boolean(),
            'archived' => $this->faker->boolean(),
            'asset_id' => $this->faker->randomNumber(),
            'serial_number' => $this->faker->word(),
            'model_number' => $this->faker->word(),
            'manufacturer' => $this->faker->word(),
            'lifetime_warranty' => $this->faker->boolean(),
            'warranty_expires' => Carbon::now(),
            'warranty_details' => $this->faker->word(),
            'purchase_time' => Carbon::now(),
            'purchase_from' => $this->faker->word(),
            'purchase_price' => $this->faker->randomFloat(),
            'sold_time' => Carbon::now(),
            'sold_to' => $this->faker->word(),
            'sold_price' => $this->faker->randomFloat(),
            'sold_notes' => $this->faker->word(),

            'location_id' => Location::factory(),

            'team_id' => Team::first()?->id ?? Team::factory()->create()->id,

        ];
    }
}
