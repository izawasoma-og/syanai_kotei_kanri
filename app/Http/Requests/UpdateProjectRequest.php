<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            "editDate" => ["required"],
            "editOperationId" => ["required","integer","min:1"],
            "editWorkingTime" => ["required","date_format:H:i"],
            "editProjectId" => ["required","integer"],
        ];
    }

    public function messages()
    {
        return [

        ];
    }

    protected function failedValidation(Validator $validator){
        $data = [
            "message" => "The given data was invalid",
            "errors" => $validator->errors()->toArray(),
        ];
        throw new HttpResponseException(response()->json($data,422));
    }

}
