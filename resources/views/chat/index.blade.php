@extends('layouts.app')


@section('content')

<div class="container">
    <h1>Чаты @if (isset($group)) Группы {{$group->name}} @endif</h1>

    @if (isset($group))
        <ul class="navbar-nav mr-auto">
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Чаты
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach($chats as $chat)
                        {!! Form::open(['method' => 'post', 'route' =>['chats.groups.add', $chat->id, $group->id]]) !!}
                        <button>{{$chat->id}}</button>
                        {!! Form::close() !!}
                    @endforeach

                </div>
            </div>
        </ul>
    @endif

    {{$table}}
</div>

@endsection
