<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'max:255'],
            'condition' => ['required'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
            'image' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '価格を入力してください',
            'price.integer' => '価格は数値で入力してください',
            'price.min' => '価格は0円以上で入力してください',
            'description.required' => '商品説明を入力してください',
            'condition.required' => '商品の状態を選択してください',
            'categories.required' => 'カテゴリを選択してください',
            'image.required' => '商品画像を選択してください',
            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => '画像はJPEGまたはPNG形式でアップロードしてください',
            'image.max' => '画像は2MG以内にしてください',
        ];
    }
}
