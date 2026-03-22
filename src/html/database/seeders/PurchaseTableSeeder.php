<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;

class PurchaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = user::first();
        $item = Item::first();

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
