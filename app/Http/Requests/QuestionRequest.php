<?php

namespace App\Http\Requests;

use App\Enums\QuestionType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class QuestionRequest extends FormRequest
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
            'question' => 'required',
            'type' => ['required', new EnumValue(QuestionType::class)],
            'values' => new RequiredIf(in_array($this->type, [QuestionType::select, QuestionType::radio])),
        ];
    }

    public function messages() {
        return [
            'question.required' => 'Введите вопрос',
            'values.required' => 'Введите варинты ответов'
        ];
    }
}
