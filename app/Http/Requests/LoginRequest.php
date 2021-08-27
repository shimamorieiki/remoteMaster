<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Symfony\Component\HttpFoundation\Response;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //[ *1.変更：default=false ]
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // [ *2.追加：Validationルール記述箇所 ]
        return [
            'email' => ['required','email'],
            'password' => ['required']
        ];
    }

    // public function messages(){
    //     return [
    //         'email.required' => 'emailを入力してください',
    //         'email.email'    => 'emailの形式が正しくありません',
    //         'password.required' => 'パスワードを入力してください',
    //     ];
    // }

    public function failedValidation(Validator $validator){
        $message = $validator->errors()->all();
        $response = response()->serverError($message);
        throw new HttpResponseException($response);
    }
}