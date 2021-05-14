@extends('layouts.app')


@section('content')
    <div class="container">

    {!! Form::model($question, ['method' =>'post' ,
                'route'=>['forms.question.answer', $form->id]]) !!}
        @if (count($answers))
            @foreach($form->questions as $key => $question)
                {!! Form::label('question', $question->question) !!}
                <br>
                {!! Form::text('question', $answers[$key]->value , ['class' => 'form-control', 'name'=> 'question'.'['.$question->id.']']) !!}
            @endforeach
        @endif

        {!! Form::close() !!}
    </div>
@endsection
