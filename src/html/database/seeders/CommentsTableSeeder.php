<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;
use App\Models\Item;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::query()->delete();

        $user = User::first();
        $items = Item::take(2)->get();

        foreach ($items as $index => $item) {
            if ($index === 0) {
                Comment::create([
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                    'content' => 'これは１件目の商品へのコメントです。',
                ]);
                Comment::create([
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                    'content' => '状態は良さそうですか？',
                ]);
            } else {
                Comment::create([
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                    'content' => 'こちらの商品も気になります。',
                ]);
            }
        }
    }
}
