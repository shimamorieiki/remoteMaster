<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'name' => ['required'],
            'grade_id' => ['required'],
            'genre_id' => ['required'],
            'description' => ['required'],
            'is_positive_check' => ['required']
        ];
    }


    // function名は必ず「messages」となります。
    public function messages(){
        return [
            'name.required' => 'nameを入力してください',
            'grade_id.required' => 'grade_idを入力してください',
            'genre_id.required' => 'genre_idを入力してください',
            'description.required' => 'descriptionを入力してください',
            'is_positive_check.required' => 'is_positive_check.requiredを入力してください'
        ];
    }

}