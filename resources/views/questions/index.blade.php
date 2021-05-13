@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Вопросы для формы {{$form->name}}</h1>
        <a href="{{route('forms.create')}}"><button class="btn bnt-primary">Создать вопрос</button></a>

        @if (count($questions))
            <table class="table">
                <th>Название формы</th>
                <th>Редактировать</th>
                <th>Удалить</th>

                @foreach($questions as $question)
                    <tr>
                        <td><a href="{{route('questions.show', $question->id)}}">{{$question->question}}</a></td>
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
