@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{$form->id ? 'Редактирование' : 'Создание'}} формы</h1>
        @if ($form->id)
            {!! Form::model($form, ['method' => 'put', 'route'=> ['forms.update', $form->id]]) !!}
        @else
            {!! Form::model($form, ['method' => 'post', 'route'=> ['forms.store']]) !!}
        @endif

        <label>Введите название вашей формы</label>
        <br>
        {!! Form::text('name', null , ['class' => 'form-control']) !!}
        <br>
        {!! Form::submit($form->id ? 'Редактировать' : 'Создать', ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection
