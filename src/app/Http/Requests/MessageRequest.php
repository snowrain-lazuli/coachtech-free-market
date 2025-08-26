<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    // 認可
    public function authorize(): bool
    {
        return true;
    }

    // バリデーションルール
    public function rules(): array
    {
        return [
            'message' => 'required|string|max:400',
            'image'   => 'nullable|file|mimes:jpeg,png',
        ];
    }

    // カスタムメッセージ
    public function messages(): array
    {
        return [
            'message.required' => '本文を入力してください',
            'message.max'      => '本文は400文字以内で入力してください',
            'image.mimes'      => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}