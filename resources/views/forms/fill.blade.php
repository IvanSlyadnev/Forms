@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Прохождение формы {{$form->name}}</h1>
        @if (count($form->questions))

            {!! Form::open(['method' =>'post' ,
                'route'=>['forms.question.answer', $form->id]]) !!}
                {!! Form::label('email', 'Ваш email') !!}
                <br>
                {!! Form::text('email', $email ,['class' => 'form-control']) !!}
                @foreach($form->questions as $question)
                    {!! Form::label('question'.$question->id, $question->question) !!}
                    {!! Form::text('question['.$question->id.']', '', ['class' => 'form-control', 'id' => 'question'.$question->id]) !!}
                @endforeach
                {!! Form::submit('Ответить', ['class' => 'btn btn-success']) !!}
            {!! Form::close() !!}
        @else
            <h1>На это форме нет вопросов</h1>
        @endif
    </div>
@endsection
