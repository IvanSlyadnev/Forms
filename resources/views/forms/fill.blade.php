@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Прохождение формы {{$form->name}}</h1>
        @if (count($form->questions))
            @foreach($form->questions as $question)
                {{$question->question}}
                <br>
                {!! Form::model($question, ['method' =>'post' ,
                    'route'=>['forms.question.answer', $form->id]]) !!}

                {!! Form::text('question', '', ['class' => 'form-control', 'name'=> 'question'.'['.$question->id.']']) !!}

            @endforeach
            {!! Form::submit('Ответить', ['class' => 'btn btn-success']) !!}
            {!! Form::close() !!}
        @else
            <h1>На это форме нет вопросов</h1>
        @endif
    </div>
@endsection
