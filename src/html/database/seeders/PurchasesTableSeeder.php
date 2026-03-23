<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Purchase::query()->delete();

        $user = User::first();
        $item = Item::first();

        if ($user && $item) {
            Purchase::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                ],
                [
                    'payment_method' => 'カード払い',
                    'postal_code' => '123-4567',
                    'address' => '東京都新宿区1-2-3',
                ]
            );
        }
    }
}
