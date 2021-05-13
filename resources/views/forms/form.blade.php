@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($form->id == null)
            <h1>Создать форму</h1>
            <?php
                $route = 'forms.store';
                $method = 'post';
                $action = 'Создать';
            ?>
        @else
            <h1>Редактировать форму</h1>
            <?php
                $route = 'forms.update';
                $method = 'put';
                $action = 'Редактировать';
            ?>
        @endif
        {!! Form::model($form, ['method' => $method, 'route'=> [$route, $form->id]]) !!}
        <label for="">Введите название вашей формы</label>
        <br>
        {!! Form::text('name', null , ['class' => 'form-control']) !!}
        <br>
        {!! Form::submit($action, ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection
