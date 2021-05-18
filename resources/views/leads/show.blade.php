@extends('layouts.app')

@section('content')
    <div class="container">
        @if (count($answers))
            {!! Form::label('', 'email') !!}

            {!! Form::text('', $lead->email ,['class' => 'form-control', 'disabled' => true]) !!}
            @foreach($answers as $answer)
                {!! Form::label('question'.$answer->question->id, $answer->question->question) !!}
                <br>
                @switch($answer->question->type)
                    @case(\App\Enums\QuestionType::input)
                        {!! Form::text('question['.$answer->question->id.']', $answer->value , ['class' => 'form-control', 'disabled' => true, 'id' => 'question'.$answer->question->id]) !!}
                        @break;
                    @case(\App\Enums\QuestionType::textarea)
                        {!! Form::textarea('question['.$answer->question->id.']', $answer->value , ['class' => 'form-control', 'disabled' => true, 'id' => 'question'.$answer->question->id]) !!}
                        @break;
                    @case(\App\Enums\QuestionType::checkbox)
                        {!! Form::checkbox('question['.$answer->question->id.']', $answer->value, $answer->value, ['disabled' => true]) !!}
                        @break;
                    @case(\App\Enums\QuestionType::radio)
                        @foreach($answer->question->values_array as $value)
                            {!! Form::label('question['.$answer->question->id.']', $value) !!}
                            {!! Form::radio('question['.$answer->question->id.']', $value, ($value == $answer->value) ? true : false, ['disabled' => true]) !!}
                        @endforeach
                        @break;
                @endswitch
            @endforeach
        @endif
    </div>
@endsection
