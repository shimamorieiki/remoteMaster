<?php
namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Symfony\Component\HttpFoundation\Response;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'     => ['required'],
            'email'    => ['required','email'],
            'password' => ['required'],
            'role_id'  => ['required']
        ];
    }

    // public function messages(){
    //     return [
    //         'name.required'       => 'nameを入力してください',
    //         'email.required'      => 'emailを入力してください',
    //         'email.email'         => 'emailの形式が正しくありません',
    //         'password.required'   => 'パスワードを入力してください',
    //         'role_id.required'    => 'role_idを入力してください',
    //     ];
    // }

    public function failedValidation(Validator $validator){
        $message = $validator->errors()->all();
        $response = response()->serverError($message);
        throw new HttpResponseException($response);
    }

}