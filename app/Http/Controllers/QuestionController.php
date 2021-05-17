<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Form;
use App\Models\Question;
use App\Tables\QuestionTable;
use \App\Enums\QuestionType;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Form $form)
    {
        $this->authorize('viewAnyQuestion', $form);
        $table = (new QuestionTable($form))->setup();
        return view('questions/index', [
            'form' => $form,
            'table' => $table
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Form $form, Question  $question)
    {
        $this->authorize('createQuestion', $form);
        return view('questions/form', [
            'question' => $question,
            'form' => $form,
            'types' =>  QuestionType::asSelectArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request, Question $question, Form $form)
    {
        $this->authorize('createQuestion', $form);
        $form->questions()->create($request->only($question->getFillable()));
        return redirect()->route('forms.questions.index', $form->id);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        return view('/questions/form', [
            'question' => $question
        ]);
    }

    /**
     * Update the specified resource in storage.
     *f
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $this->authorize('update', $question);
        $question->update($request->only($question->getFillable()));
        return redirect()->route('forms.questions.index', $question->form)->with('success', 'Вопрос успешно изменен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);
        $question->delete();
        return redirect()->route('forms.questions.index', $question->form)->with('success', 'Вопрос успешно удален');
    }
}
