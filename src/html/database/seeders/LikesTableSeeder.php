<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Like;
use App\Models\User;
use App\Models\Item;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Like::query()->delete();

        $user = User::first();
        $items = Item::take(2)->get();

        foreach ($items as $item) {
            Like::firstOrCreate([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
        }
    }
}
