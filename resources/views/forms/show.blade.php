@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Форма {{$form->name}} вопросы:</h1>
        <a href="{{route('forms.questions.create', $form)}}"><button class="btn bnt-primary">Создать вопрос</button></a>
        @if ($form->questions()->count())
            <table class="table">
                <th>Номер</th>
                <th>Вопрос</th>
                <th>Редактировать</th>
                <th>Удалить</th>

                @foreach($form->questions as $key =>$question)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$question->question}}</td>
                        <td><a href="{{route('questions.edit', $question->id)}}">
                                <button class="btn btn-primary">Редактировать</button>
                            </a>
                        </td>
                        <td>
                            {!! Form::open(['method'=> 'delete', 'route' =>['questions.destroy', $question->id]]) !!}
                                <button class="btn btn-danger">Удалить</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
@endsection
