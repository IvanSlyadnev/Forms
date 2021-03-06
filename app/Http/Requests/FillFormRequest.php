<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FillFormRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'question' => 'required|array',
            'question.*' => 'required',
            'email' => 'required'
        ];
    }

    public function messages() {
        return [
            'question.required' => 'Введите ответы на вопросы',
            'email.required' => 'Введите email'
        ];
    }
}
