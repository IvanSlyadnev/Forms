@extends('layouts.app')


@section('content')


    <div class="container">

        <ul class="navbar-nav mr-auto">
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Пользователи
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach($users as $user)
                        {!! Form::open(['method' => 'post', 'route' =>['user.add', $user->id, $chat->id]]) !!}
                            <button>{{$user->name}}</button>
                        {!! Form::close() !!}
                    @endforeach

                </div>
            </div>
        </ul>
        {{$table}}
    </div>

@endsection
