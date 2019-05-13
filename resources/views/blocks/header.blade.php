<header class="header">
    <div class="container">
        <div class="header__inner">
            <div class="header__logo">
                <a href="{{route('home')}}" class="_link"><img src="{{asset('images/logo-blue.svg')}}" alt=""></a>
            </div>

            <div class="header__nav">
                <div class="_action js-open-menu"><i class="_open"></i> <i class="_close"></i></div>
                <div class="_list">
                    <div class="_item categories"><a href="{{route('categories')}}" class="_link"><i></i> Categories</a></div>
                    <div class="_item top"><a href="{{route('products.top')}}" class="_link"><i></i> Top software</a></div>
                    @auth
                        @if(Auth::user()->moderator_id) <div class="_item"><a href="{{route('user.index')}}" class="_link"><i class="fas fa-user"></i> Cabinet</a></div> @endif
                    @endauth
                    <div class="_item"><button class="btn btn-purple btn-big btn-add" onclick="loginShow()"><i></i>Add reviews</button></div>
                </div>
            </div>
        </div>
    </div>
</header>