@extends('layouts.app')


@section('content')
    <div class="container">
        @if (count($answers))
            {!! Form::label('', 'email') !!}
            {!! Form::text('', $lead->email ,['class' => 'form-control', 'disabled' => true]) !!}
            @foreach($form->questions as $key => $question)
                {!! Form::label('question'.$question->id, $question->question) !!}
                <br>
                {!! Form::text('question['.$question->id.']', $answers[$key]->value , ['class' => 'form-control', 'disabled' => true, 'id' => 'question'.$question->id]) !!}
            @endforeach
        @endif
    </div>
@endsection
