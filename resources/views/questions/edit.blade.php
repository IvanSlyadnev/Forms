@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактирование вопроса</h1>
        {!! Form::open(['method' => 'put', 'route'=> ['questions.update', $question->id], 'class' => 'form-line']) !!}
        <label for="">Введите название выешго вопроса</label>
        <br>
        {!! Form::text('question', $question->question, ['class' => 'form-control']) !!}
        <br>
        {!! Form::submit('Редактировать', ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection
