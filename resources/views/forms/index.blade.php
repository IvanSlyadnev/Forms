@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ваши формы</h1>
        <a href="{{route('forms.create')}}"><button class="btn bnt-primary">Создать форму</button></a>
        @if (count($forms))
            {{$table}}
        @endif
    </div>
@endsection
