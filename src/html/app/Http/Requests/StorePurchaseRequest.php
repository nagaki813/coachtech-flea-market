<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
            'item_id' => ['required', 'exists:items,id'],
            'payment_method' => ['required', 'in:card,convenience'],
            'postal_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required', 'string'],
            'building' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'item_id.required' => '商品情報が不正です。',
            'item_id.exists' => '存在しない商品です。',

            'payment_method.required' => '支払方法を選択してください。',
            'payment_method.in' => '正しい支払方法を選択してください。',

            'postal_code.required' => '郵便番号を入力してください。',
            'postal_code.regex' => '郵便番号はハイフンありの形式で入力してください',

            'address.required' => '住所を入力してください',
            'address.string' => '住所は文字列で入力してください',
        ];
    }
}
