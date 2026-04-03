<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'content' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'item_id.required' => '商品情報が不足しています',
            'item_id.exists' => '対象の商品が存在しません',
            'content.required' => 'コメントを入力してください',
            'content.string' => 'コメントは文字列で入力してください',
            'content.max' => 'コメントは255文字以内で入力してください',
        ];
    }
}
