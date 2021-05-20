<?php

namespace App\Http\Controllers;

use App\Http\Requests\FillFormRequest;
use App\Models\Form;
use App\Models\Lead;
use App\Notifications\FormOwnerNotification;
use App\Notifications\InvoicePaid;
use App\Notifications\LeadNotification;
use Illuminate\Http\Request;

class QuestionAnswerController extends Controller
{
    public function fillForm(FillFormRequest $request, Form $form) {
        $lead = $form->leads()->create($request->only((new Lead())->getFillable()));
        foreach ($request->question as $question_id => $question) {
            $lead->answers()->create(['value'=> $question, 'question_id' => $question_id]);
        }
        $lead->notify(new LeadNotification());
        $form->user->notify(new FormOwnerNotification($lead));
        return redirect()->route('forms.fill', $form->id)->with('success', 'форма успешно сохранена');
    }
}
