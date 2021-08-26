<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Symfony\Component\HttpFoundation\Response;

class LotteryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'voting_number' => ['required','regex:/^[1-9]*[0-9]+$/']
        ];
    }

    // public function messages(){
    //     return [
    //         'voting_number.required' => '数字を入力してください',
    //         'voting_number.regex'    => '自然数を入力してください'
    //     ];
    // }


    public function failedValidation(Validator $validator){
        $message = $validator->errors()->all();
        $response = response()->serverError($message);
        throw new HttpResponseException($response);
    }

}