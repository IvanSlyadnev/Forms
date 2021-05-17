@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{$question->id ? 'Редактирование' : 'Создание'}} вопроса</h1>
        @if ($question->id)
            {!! Form::model($question, ['method' => 'put', 'route'=> ['questions.update', $question->id]]) !!}
        @else
            {!! Form::model($question, ['method' => 'post', 'route'=> ['forms.questions.store', $form->id]]) !!}
        @endif
        {!! Form::label('question'.$question->id, 'Введите название вашего вопроса') !!}
        <br>
        {!! Form::select('type', ['input'=> 'инпут', 'text' => 'текстовый']) !!}
        <br>
        {!! Form::text('question', null , ['class' => 'form-control']) !!}
        <br>

        {!! Form::submit($question->id ? 'Редактировать' : 'Создать', ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection
