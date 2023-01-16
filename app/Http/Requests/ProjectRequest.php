<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            "formClientId" => "required|integer|min:1",
            "formName" => "required",
        ];
    }

    public function messages()
    {
        return [
            //入力項目のバリデーション
            "formClientId.required" => "顧客名を選択してください。",
            "formClientId.integer" => "顧客名を正しく選択した上で、idが記入されていることを確認してください。",
            "formClientId.min" => "顧客名を正しく選択した上で、idが記入されていることを確認してください。",
            "formName.required" => "プロジェクト名は必須項目です",
        ];
    }

}
