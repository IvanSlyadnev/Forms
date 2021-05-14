<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Question;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show(Lead $lead)
    {
        return view('leads/show', [
            'form' => $lead->form,
            'answers' => $lead->answers,
            'question' => new Question()
        ]);
    }

}
