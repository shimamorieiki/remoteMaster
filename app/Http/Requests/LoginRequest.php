<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

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


    // function名は必ず「messages」となります。
    public function messages(){
        return [
            'email.required' => 'emailを入力してください',
            'email.email'    => 'emailの形式が正しくありません',
            'password.required' => 'パスワードを入力してください',
        ];
    }

}