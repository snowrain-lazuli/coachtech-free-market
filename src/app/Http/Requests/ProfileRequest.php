<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:51200',
            'name' => 'required',
            'post_code' => 'required|numeric|digits:7',
            'address' => 'required|max:255',
            'building' => 'required|max:255'
        ];
    }
    /**
     *  バリデーション項目名定義
     * @return array
     */

    public function messages()
    {
        return [
            'name.required' => 'お名前を入力して下さい。',
            'name.unique' => 'その名前はすでに使用されています。',
            'post_code.required' => '郵便番号を入力してください。',
            'post_code.numeric' => '郵便番号は数字7桁で入力してください。',
            'post_code.min' => '郵便番号は数字7桁で入力してください。',
            'post_code.mix' => '郵便番号は数字7桁で入力してください。',
            'address.required' => '住所を入力してください。',
            'address.min' => '住所は255文字以下で入力してください。',
            'building.required' => '建物を入力してください。',
            'building.min' => '建物は255文字以下で入力してください。'
        ];
    }
}