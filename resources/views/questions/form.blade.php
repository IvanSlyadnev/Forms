@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($question->id == null)
            <h1>Создать вопрос</h1>
            <?php
                $route = 'forms.questions.store';
                $method = 'post';
                $id = $form->id;
                $action = 'Создать';
            ?>
        @else
            <h1>Редактировать вопрос</h1>
            <?php
                $route = 'questions.update';
                $method = 'put';
                $id = $question->id;
                $action = 'Редактировать';
            ?>
        @endif
        {!! Form::model($question, ['method' => $method, 'route'=> [$route, $id]]) !!}
        <label for="">Введите название вашего вопроса</label>
        <br>
        {!! Form::text('question', null , ['class' => 'form-control']) !!}
        <br>
        {!! Form::submit($action, ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection
