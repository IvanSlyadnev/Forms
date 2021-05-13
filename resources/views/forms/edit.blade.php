@extends('layouts.app')

@section('content')
    <div class="container">
        @include ('mis.mistake')
        <h1>Редактирование формы</h1>
        {!! Form::open(['method' => 'put', 'route'=> ['forms.update', $form->id]]) !!}
        <label for="">Введите название вашей формы</label>
        <br>
        {!! Form::text('name', $form->name, ['class' => 'from-line']) !!}
        <br>
        {!! Form::submit('Редактировать', ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection
