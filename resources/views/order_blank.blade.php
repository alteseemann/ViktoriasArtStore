@extends('layouts.app')
@section('title')
    Оформление заказа
@endsection
@section('content')
    @if(isset($errors))
        @foreach($errors as $error)
            <div class="p-2 bg-danger">{{$error}}</div>
        @endforeach
    @endif
    <div class="pt-3">
        <div class="font-weight-bold mb-3">Ваш заказ:</div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Товар</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Стоимость</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['cart'] as $key=>$value)
            <tr>
                <th scope="row">{{$value[4]}}</th>
                <td>{{$value[0]}} Р</td>
                <td>{{$value[1]}}</td>
                <td>{{$value[2]}} Р</td>
            </tr>
            @endforeach
            <tr>
                <th scope="row">Итого</th>
                <td></td>
                <td></td>
                <td>{{$data['cart_price']}} Р</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div>
        <div class="w-50">
            <div class="font-weight-bold">
                Контактные данные:
            </div>
            <div>
                <form class="mt-3" action="{{route('start_payment')}}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="user_name" class="col-sm-2 col-form-label">Имя</label>
                        <div class="col-sm-10">
                            <input name="user_name" class="form-control" id="user_name" placeholder="Имя">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="user_surname" class="col-sm-2 col-form-label">Фамилия</label>
                        <div class="col-sm-10">
                            <input name="user_surname" class="form-control" id="user_surname" placeholder="Фамилия">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="user_patronymic" class="col-sm-2 col-form-label">Отчество</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="user_patronymic" placeholder="Отчество">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label">Телефон</label>
                        <div class="col-sm-10">
                            <input name="phone" class="form-control" id="phone" placeholder="Номер телефона с восьмеркой">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-sm-2 col-form-label">Адрес доставки</label>
                        <div class="col-sm-10">
                            <input name="address" class="form-control" id="address" placeholder="Адрес">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="index" class="col-sm-2 col-form-label">Почтовый индекс</label>
                        <div class="col-sm-10">
                            <input name="index" class="form-control" id="index" placeholder="Индекс">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-success">Подтвердить</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
