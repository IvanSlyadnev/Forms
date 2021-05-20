<div>
    {!! Form::label('question'.$question->id, $question->question) !!}
    @switch($question->type)
        @case(\App\Enums\QuestionType::input)
        {!! Form::text('question['.$question->id.']', (isset($answer)) ? $answer->value : '', ['class' => 'form-control', 'id' => 'question'.$question->id, 'disabled' => (isset($disabled))]) !!}
        @break;
        @case(\App\Enums\QuestionType::textarea)
        {!! Form::textarea('question['.$question->id.']', (isset($answer)) ? $answer->value : '', ['class' => 'form-control', 'id' => 'question'.$question->id, 'disabled' => (isset($disabled))])!!}
        @break;
        @case(\App\Enums\QuestionType::select)
        {!! Form::select('question['.$question->id.']', $question->values_array, (isset($answer)) ? $answer->value : '', ['disabled' => (isset($disabled))]) !!}
        @break;
        @case(\App\Enums\QuestionType::checkbox)
        {!! Form::hidden('question['.$question->id.']', 0) !!}
        {!! Form::checkbox('question['.$question->id.']', true, (isset($answer)) ? $answer->value : '', ['disabled' => (isset($disabled))]) !!}
        @break;
        @case(\App\Enums\QuestionType::file)
            @if (isset($answer))
                {!! Form::label('file', $question->question) !!}
                <br>
                <img src="{{\Illuminate\Support\Facades\Storage::url($answer->value)}}" alt="">
            @else
                {!! Form::label('file', 'Загрузите ваш файл') !!}
                {!! Form::file('question['.$question->id.']', ['class' => 'form-control']) !!}

        @endif
        @break;
        @case(\App\Enums\QuestionType::radio)
        @foreach($question->values_array as $value)
            {!! Form::label('question['.$question->id.']', $value) !!}
            {!! Form::radio('question['.$question->id.']', $value, (isset($answer)) ? $answer->value==$value : '', ['disabled' => (isset($disabled))]) !!}
        @endforeach
        @break;
    @endswitch
</div>
