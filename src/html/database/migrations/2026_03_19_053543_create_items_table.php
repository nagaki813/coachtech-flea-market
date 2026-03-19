<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            //　出品者 (usersとのリレーション)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // 商品情報
            $table->string('name');
            $table->string('brand_name')->nullable();
            $table->text('description');
            $table->integer('price');

            // 商品状態 (tinyInteger)
            $table->tinyInteger('condition');

            // 画像パス
            $table->string('image_path');

            // 売り切れフラグ
            $table->boolean('is_sold')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
