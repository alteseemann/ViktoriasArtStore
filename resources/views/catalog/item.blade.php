@extends('layouts.app')
@section('title')
    {{$product->rus_title}}
@endsection
@section('content')
<!--Слайдер изображений-->
<div class="row justify-content-center">
    <div class="sale-bg row justify-content-center mt-4" id="fotorama">
        <div class="fotorama"
             data-nav="thumbs"
             data-allowfullscreen="true"
             data-loop="true">
            @if(count($product->images)>0)
            @foreach ($product->images as $image)
                <img class="d-block sale_pic"
                     src="{{Storage::url($image->path)}}"
                     data-src="holder.js/900x400?theme=industrial"
                     alt="Second slide">
            @endforeach
            @else
                <img
                    class="d-block sale_pic"
                    src="{{Storage::url($product->type->image)}}"
                    data-src="holder.js/900x400?theme=industrial"
                    alt="Second slide">
            @endif
        </div>
    </div>
</div>
<!--Слайдер изображений-->

<!--Описание товара-->
<div class="row justify-content-center mt-3">
    <div class="sale-bg" id="sale_description">
        <ul class="nav nav-tabs">

            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#description">
                    <img src="/images/svg/description.svg" width="15" height="15" class="ml-1 mr-1">
                    Описание
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#contacts">
                    <img src="/images/svg/contact.svg" width="15" height="15" class="ml-1 mr-1">
                    Контакты
                </a>
            </li>
            @if(Auth::user() && Auth::user()->id == $product->user_id)
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#edit">
                        <img src="/images/svg/edit.svg" width="15" height="15" class="ml-1 mr-1">
                        Редактирование
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#buy">
                    <img src="/images/svg/wallet.svg" width="15" height="15" class="ml-1 mr-1">
                    Покупка
                </a>
            </li>
        </ul>
        <div class="tab-content mt-2">
            <div class="tab-pane fade show active ml-2" id="description">
                {{$product->description}}
            </div>
            <div class="tab-pane fade ml-2" id="contacts">
                <div class="row">
                    <div class="column w-50 sale_parameter">
                        Адрес
                    </div>
                    <div class="column w-50 sale_parameter text-left">

                    </div>
                </div>
                <div class="row">
                    <div class="column w-50 sale_parameter">
                        Телефон
                    </div>
                    <div class="column w-50 sale_parameter text-left">

                    </div>
                </div>
                <div class="row">
                    <div class="column w-50 sale_parameter">
                        E-mail
                    </div>
                    <div class="column w-50 sale_parameter text-left">

                    </div>
                </div>
                <div class="row">
                    <div class="column w-50 sale_parameter">
                        Сайт продавца
                    </div>
                    <div class="column w-50 sale_parameter text-left">
                        <a href=""></a>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade ml-2" id="edit">
                <form class="w-50 ml-3" action="{{route('post_edit',[$product->id])}}">
                    @csrf
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Sign in</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade ml-3" id="buy">
                <div class="vidget ml-2">
                    <cart_vidget v-bind:id="{{$product->id}}"></cart_vidget>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Описание товара-->

@endsection
