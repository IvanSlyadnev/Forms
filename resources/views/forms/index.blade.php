@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ваши формы</h1>
        <a href="{{route('forms.create')}}"><button class="btn bnt-primary">Создать форму</button></a>
        @if (count($forms))
            <table class="table">
                <th>Название формы</th>
                <th>Редактировать</th>
                <th>Удалить</th>

                @foreach($forms as $form)
                    <tr>
                        <td><a href="{{route('forms.show', $form->id)}}">{{$form->name}}</a></td>
                        <td><a href="{{route('forms.edit', $form->id)}}">
                                <button class="btn btn-primary">Редактировать</button>
                            </a>
                        </td>
                        <td>
                            {!! Form::open(['method'=> 'delete', 'route' =>['forms.destroy', $form->id]]) !!}
                                <button class="btn btn-danger">Удалить</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>

                @endforeach
            </table>
        @endif
    </div>
@endsection
