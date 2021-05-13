@extends('layouts.app')

@section('content')
    <div class="container">
        @include ('mis.mistake')
        <h1>Создание Вопроса</h1>
        {!! Form::open(['method' => 'post', 'route'=> ['forms.questions.store', $form->id], 'class' => 'form-line']) !!}
        <label for="">Введите название вышего вопроса</label>
        <br>
        {!! Form::text('question', '', ['class' => 'form-control']) !!}
        <br>
        {!! Form::submit('Создать', ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection
