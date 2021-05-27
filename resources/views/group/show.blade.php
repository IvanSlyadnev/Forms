@extends('layouts.app')


@section('content')

    <div class="container">
        <h1>Группа {{$group->name}}</h1>
        <ul class="navbar-nav mr-auto">
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Пользователи
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach($users as $user)
                        {!! Form::open(['method' => 'post', 'route' =>['users.groups.add', $user->id, $group->id]]) !!}
                        <button>{{$user->name}}</button>
                        {!! Form::close() !!}
                    @endforeach

                </div>
            </div>
        </ul>

        {{$table}}
    </div>

@endsection


