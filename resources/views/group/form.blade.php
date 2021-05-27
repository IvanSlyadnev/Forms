@extends('layouts.app')


@section('content')

    <div class="container">

        <h1>{{$group->id ? 'Редактирование' : 'Создание'}} Группы</h1>
        @if ($group->id)
            {!! Form::model($group, ['method' => 'put', 'route' => ['groups.update', $group->id]]) !!}
        @else
            {!! Form::model($group, ['method' => 'post', 'route' => ['groups.store']]) !!}
        @endif

        {!! Form::label('name', 'Введите название группы') !!}

        {!! Form::text('name', $group->id ? $group->name : null, ['class' => 'form-control']) !!}

        {!! Form::submit($group->id ? 'Редактировать' : 'Создать', ['class' => 'btn btn-success']) !!}

        {!! Form::close() !!}
    </div>

@endsection
