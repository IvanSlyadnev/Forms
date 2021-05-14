@extends('layouts.app')


@section('content')
    <div class="container">
        @foreach($form->questions as $key => $question)
            {{$question->question}}
            <br>
            {!! Form::model($question, ['method' =>'post' ,
                'route'=>['forms.question.answer', $form->id]]) !!}

            {!! Form::text('question', $answers[$key]->value , ['class' => 'form-control', 'name'=> 'question'.'['.$question->id.']']) !!}

        @endforeach
    </div>
@endsection
