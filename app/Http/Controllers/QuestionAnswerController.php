<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class QuestionAnswerController extends Controller
{
    public function foo(Request $request, Form $form) {
        $lead = $form->leads()->create();
        foreach ($request->input()['question'] as $question_id => $question) {
            $lead->answers()->create(['value'=> $question, 'question_id' => $question_id]);
        }
        return redirect()->route('forms.fill', $form->id)->with('success', 'форма успешно сохранена');
    }
}
