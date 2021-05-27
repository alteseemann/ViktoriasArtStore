@extends('layouts.app')
@section('title')
    Добавить товар
@endsection
@section('content')
    <form method="POST" action="{{route('post_submit')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="product_name" class="col-sm-2 col-form-label">Название</label>
            <div class="col-sm-10">
                <input class="form-control" id="product_name" name="product_name" placeholder="Название" oninput="translit()">
            </div>
        </div>

        <input type="hidden" id="product_title" name="product_title">

        <div class="form-group row">
            <label for="type_select" class="col-sm-2 col-form-label">Выберете тип</label>
            <div class="col-sm-10">
                <select class="custom-select" id="type_select" name="type_select">
                    <option selected>Выберете тип</option>
                    @foreach($types as $type)
                        @if ($type->is_active == 1)
                        <option value="{{$type->id}}">{{$type->rus_title}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="product_price" class="col-sm-2 col-form-label">Цена</label>
            <div class="col-sm-10">
                <input class="form-control" id="product_price" name="product_price" placeholder="Цена">
            </div>
        </div>

        @for ($i=1;$i<=3;$i++)
            <div class="form-group row">
                <input type="file" class="form-control-file" id="img{{$i}}" name="img{{$i}}">
            </div>
        @endfor

        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">Готово</button>
            </div>
        </div>

    </form>
    @if(isset($errors))
        @foreach($errors as $error)
            {{$error}}
        @endforeach
    @endif
@endsection
@section('scripts')
<script type="text/javascript" src="/js/transliterator.js"></script>
@endsection
