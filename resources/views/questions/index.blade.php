@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Вопросы для формы {{$form->name}}</h1>
        <a href="{{route('forms.questions.create', $form->id)}}"><button class="btn bnt-primary">Создать вопрос</button></a>

        {{$table}}
    </div>
@endsection
