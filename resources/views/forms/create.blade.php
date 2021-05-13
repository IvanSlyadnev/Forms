@extends('layouts.app')

@section('content')
    <div class="container">
        @include ('mis.mistake')
        <h1>Создание форм</h1>
        {!! Form::open(['method' => 'post', 'route'=> ['forms.store'], 'class' => 'form-line']) !!}
        <label for="">Введите название вашей формы</label>
        <br>
        {!! Form::text('name', '', ['class' => 'form-control']) !!}
        <br>
        {!! Form::submit('Создать', ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection
