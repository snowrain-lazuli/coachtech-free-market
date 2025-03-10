<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
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
            'name' => 'required',
            'password' => 'required',
        ];
    }
    /**
     *  バリデーション項目名定義
     * @return array
     */

    public function messages()
    {
        return [
            'name.required' => 'ユーザー名またはメールアドレスを入力してください',
            'password.required' => 'パスワードを入力してください',
        ];
    }
    /**
     *  バリデーション項目名定義
     * @return array
     */
    public function attributes()
    {
        return [];
    }

    public function withValidator($validator)
    {

        $validator->after(function ($validator) {
            $usernameOrEmail = $this->input('name');
            $password = $this->input('password');

            // メールアドレスかユーザー名かを判定
            if (strpos($usernameOrEmail, '@') !== false) {
                // メールアドレスの場合
                $user = User::where('email', $usernameOrEmail)->first();

                //メールアドレスが一致しなかった場合バリテーションを設定
                if (!$user) {
                    $validator->errors()->add('no_data', 'ログイン情報が登録されていません。');
                } else {
                    // メールアドレスが存在する場合、パスワードのチェック
                    if (!Hash::check($password, $user->password)) {
                        $validator->errors()->add('no_data', 'ログイン情報が登録されていません。');
                    }
                }
            } else {
                // ユーザー名の場合
                $user = User::where(
                    'name',
                    $usernameOrEmail
                )->first();

                //ユーザー名が一致しなかった場合バリテーションを設定
                if (!$user) {
                    $validator->errors()->add('no_data', 'ログイン情報が登録されていません。');
                } else {
                    // ユーザー名が存在する場合、パスワードのチェック
                    if (!Hash::check($password, $user->password)) {
                        $validator->errors()->add('no_data', 'ログイン情報が登録されていません。');
                    }
                }
            }
        });
    }
}