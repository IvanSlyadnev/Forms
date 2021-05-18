@extends('layouts.app')

@section('content')
    <div class="container">
        @if (count($answers))
            {!! Form::label('', 'email') !!}

            {!! Form::text('', $lead->email ,['class' => 'form-control', 'disabled' => true]) !!}
            @foreach($answers as $answer)
                @include('inputs.inputs', ['question' => $answer->question, 'answer' => $answer, 'disabled' => true])
            @endforeach
        @endif
    </div>
@endsection
