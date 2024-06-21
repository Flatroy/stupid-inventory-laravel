<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Location;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Random\RandomException;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @throws RandomException
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        User::factory()->withPersonalTeam()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => 'demo@example.com',
        ]);

        $tags = collect([
            'Appliances',
            'IOT',
            'Electronics',
            'Servers',
            'General',
            'Important',
        ])->map(fn ($tag) => Tag::factory()->create([
            'name' => $tag,
        ]));

        $locations = collect([
            'Living Room',
            'Garage',
            'Kitchen',
            'Bedroom',
            'Bathroom',
            'Office',
            'Attic',
            'Basement',
        ])->map(fn ($location) => Location::factory()->create([
            'name' => $location,
        ]));

        $items = Item::factory(100)->create([
            //            'tags' => $tags->random(random_int(1,3)),
            'location_id' => $locations->random(),
        ]);
        $items->each(function ($item) use ($tags) {

            $tagCount = mt_rand(1, 3);
            $tags->random($tagCount)->each(function ($tag) use ($item) {
                $item->tags()->attach($tag);
            });
        });
    }
}
