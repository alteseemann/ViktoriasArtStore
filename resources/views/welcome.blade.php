@extends('layouts.app')
@section('title')
    Добро пожаловать!
@endsection
@section('content')
    @if(isset($errors))
        @foreach($errors as $error)
            <div class="p-2 bg-danger">{{$error}}</div>
        @endforeach
    @endif
    <catalog v-bind:all_products="{{json_encode($products)}}"
             :all_types="{{json_encode($types)}}"
             :all_genres="{{json_encode($genres)}}"
             :all_artists="{{json_encode($artists)}}">
    </catalog>
@endsection
