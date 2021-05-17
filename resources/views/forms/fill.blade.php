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
                    <div>
                        @switch($question->type)
                            @case(\App\Enums\QuestionType::input)
                            {!! Form::text('question['.$question->id.']', '', ['class' => 'form-control', 'id' => 'question'.$question->id]) !!}
                            @break;
                            @case(\App\Enums\QuestionType::textarea)
                            {!! Form::textarea('question['.$question->id.']', '', ['class' => 'form-control', 'id' => 'question'.$question->id])!!}
                            @break;
                            @case(\App\Enums\QuestionType::select)
                            {!! Form::select('question['.$question->id.']', $question->values_array) !!}
                            @break;
                            @case(\App\Enums\QuestionType::checkbox)
                            {!! Form::hidden('question['.$question->id.']', 0) !!}
                            {!! Form::checkbox('question['.$question->id.']', true) !!}
                            @break;
                            @case(\App\Enums\QuestionType::radio)
                            @foreach($question->values_array as $value)
                                {!! Form::label('question['.$question->id.']', $value) !!}
                                {!! Form::radio('question['.$question->id.']', $value, true) !!}
                            @endforeach
                            @break;
                        @endswitch
                    </div>
                @endforeach
            <br>
                {!! Form::submit('Ответить', ['class' => 'btn btn-success']) !!}
            {!! Form::close() !!}
        @else
            <h1>На это форме нет вопросов</h1>
        @endif
    </div>
@endsection
