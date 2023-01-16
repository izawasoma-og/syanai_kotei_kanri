<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            "report.*.project_id" => ["required","integer"],
            "report.*.working_time" => ["required","date_format:H:i"],
            "report.*.operation_id" => ["required","integer","min:1"],
            "report.*.url" => ["required","url"],
            "date" => ["required"],
        ];
    }

    public function messages()
    {
        return [
            //入力項目のバリデーション
        ];
    }

    protected function prepareForValidation(){
        //入力値を選定
        $input_datas = $this->report;
        $return_input_datas = [];
        foreach($input_datas as $key => $input_data){
            $flg = false;
            if(!$input_data["operation_id"] == 0){
                $flg = true;
            }
            if(!is_null($input_data["project_id"])){
                $flg = true;
            }
            if(!is_null($input_data["working_time"])){
                $flg = true;
            }
            if($flg){
                $return_input_datas[] = $input_data;
            }
        }
        $this->merge(['report' => $return_input_datas,'date' => $this->date]);
    }
}
