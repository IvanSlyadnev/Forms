<?php

namespace App\Http\Controllers;

use App\Http\Requests\FillFormRequest;
use App\Models\Form;
use Illuminate\Http\Request;

class QuestionAnswerController extends Controller
{
    public function fillForm(FillFormRequest $request, Form $form) {
        $lead = $form->leads()->create();
        foreach ($request->question as $question_id => $question) {
            $lead->answers()->create(['value'=> $question, 'question_id' => $question_id]);
        }
        return redirect()->route('forms.fill', $form->id)->with('success', 'форма успешно сохранена');
    }
}
