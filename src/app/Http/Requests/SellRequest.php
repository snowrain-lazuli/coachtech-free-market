<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
            'condition' => 'required',
            'name' => 'required',
            'brand' => 'required',
            'details' => 'required',
            'price' => 'required|Integer',
            'categories' => 'required|array',
        ];
    }
    /**
     *  バリデーション項目名定義
     * @return array
     */

    public function messages()
    {
        return [
            'condition.required' => '状態を選択してください。',
            'name.required' => '商品名を入力してください。',
            'brand.required' => 'ブランド名を入力してください。',
            'details.required' => '商品の説明を入力してください。',
            'price.required' => '価格を入力してください。',
            'price.Integer' => '価格は整数値で入力してください。',
            'categories' => 'カテゴリーは1つ以上選択してください。',
        ];
    }


    public function attributes()
    {
        return [];
    }
}