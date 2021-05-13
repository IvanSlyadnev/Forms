<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormForRequest;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('forms/index', [
            'forms' => $request->user()->forms
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Form $form)
    {
        return view('forms/create', [
            'form' => $form
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(FormForRequest $request, Form $form)
    {
        if ($form->createForm($request->user(), $request->only($form->getFillable()))) {
                return redirect()->route('forms.index')->with('success', 'Форма успешно создана');
            } else abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        return view('forms/show', [
            'form' => $form
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {

        return view('forms/edit', [
            'form' => $form
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormForRequest $request, Form $form)
    {
        if ($form->updateForm($request->user(), $request->only($form->getFillable()))) {
            return redirect()->route('forms.index')->with('success', 'Форма успешно изменена');
        } else abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        //$this->authorize('delete', $form);
        $form->deleteForm();
        return redirect()->route('forms.index')->with('success', 'Форма успешно удалена');
    }
}
