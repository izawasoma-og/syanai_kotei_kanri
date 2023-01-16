<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\passChar;

class PasswordUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //入力項目のバリデーション
            "newPass" => ["required","min:8","confirmed",new passChar],
        ];
    }

    public function messages()
    {
        return [
            //入力項目のバリデーション
            "newPass.required" => "新しいパスワードを入力してください",
            "newPass.min" => "パスワードは最低8文字から設定してください",
            "newPass.confirmed" => "確認用パスワードと一致しませんでした",
        ];
    }

}
