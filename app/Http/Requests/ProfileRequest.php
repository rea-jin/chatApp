<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule; // ここを追加
use Auth; // ここを追加

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // authorizeメソッドは、ユーザーがデータを更新するための権限を持っているかどうかを確認するため
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * rulesメソッドはバリデーションルール
     */
    public function rules()
    {
        $myEmail = Auth::user()->email; // 追加

        return [
            //
            // ここから追加
            'name' => 'required|string|max:255',
            'email' => ['required', 
                        'string', 
                        'email', 
                        'max:255', 
                        // Auth::user()->email;と書くことで、ログイン済みユーザーのメールアドレスを取得
                        // [Rule::unique('users', 'email')でユーザー情報のメールアドレスがユニークであるか確認しつつ
                        // whereNot('email', $myEmail)]で、ログイン済みユーザーのメールアドレスは除外
                        Rule::unique('users', 'email')->whereNot('email', $myEmail)],
            // ここまで追加
        ];
    }
}
