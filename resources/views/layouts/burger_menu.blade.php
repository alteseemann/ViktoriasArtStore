<div class="burger-menu">

    <a href="#" class="burger-menu__button">
        <span class="burger-menu__lines"></span>
    </a>

    <nav class="burger-menu__nav" id="bm_nav">
        @if (auth()->user() and auth()->user()->role_id == 1)
            <a href="/admin" class="burger-menu__link">Администрирование</a>
        @endif
        @if (Route::has('login'))
            @auth
                <a href="{{ route('logout') }}" class="burger-menu__link">Выход</a>
            @else
                <a href="{{ url('/login') }}" class="burger-menu__link">Вход</a>
                @if (Route::has('register'))
                    <a href="{{ url('/register') }}" class="burger-menu__link">Регистрация</a>
                @endif
            @endif
        @endif

        <a href="/" class="burger-menu__link">Главная</a>
        <a href="{{route('cart_show')}}" class="burger-menu__link">Корзина</a>
        @foreach($types as $type)
           <a href="{{route('type_filter',[$type->id])}}" class="burger-menu__link">{{$type->chego_title}}</a>
        @endforeach
        <!--foreach-->
    </nav>
    <div class="burger-menu__overlay"></div>
</div>

