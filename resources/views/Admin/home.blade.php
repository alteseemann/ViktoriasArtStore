@extends('layouts.app')
@section('title')
    Администрирование
@endsection
@section('content')
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td><a href="{{route('post_add')}}">Добавить товар</a></td>
            </tr>
        </tbody>
    </table>
@endsection
