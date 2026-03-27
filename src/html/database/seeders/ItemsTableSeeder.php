<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'テストユーザー', 'password' => Hash::make('password'),]
        );

        DB::table('category_item')->delete();
        Item::query()->delete();

        $item1 = Item::create([
            'user_id' => $user->id,
            'name' => 'ナイキ',
            'brand_name' => 'ナイキ',
            'description' => 'テスト用の商品です',
            'price' => 3000,
            'condition' => 1,
            'image_path' => 'items/sample1.jpg',
            'is_sold' => false,
        ]);

        $item2 = Item::create([
            'user_id' => $user->id,
            'name' => 'サンプル商品2',
            'brand_name' => 'ユニクロ',
            'description' => 'テスト用の商品です',
            'price' => 1500,
            'condition' => 2,
            'image_path' => 'items/sample2.jpg',
            'is_sold' => false,
        ]);

        $item1->categories()->attach([1, 4]);
        $item2->categories()->attach([1, 5]);
    }
}
