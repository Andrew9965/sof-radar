<footer class="footer">
    <div class="container">
        <div class="footer__inner">
            <div class="footer__logo">
                <a href="/" class="_link"><img src="{{asset('images/logo-white.svg')}}"></a>
            </div>

            <div class="footer__nav">
                <div class="_list">
                    @foreach(\App\Models\BottomMenu::where('active', 1)->get() as $bm)
                        <div class="_item"><a href="{{$bm->link}}" target="{{$bm->target}}">{{$bm->title}}</a></div>
                    @endforeach
                </div>
            </div>

            <div class="footer__social">
                <div class="_label">Folow us:</div>
                <div class="_list">
                    <a href="{{config('social.twitter')}}" class="_link tw"><i></i></a>
                    <a href="{{config('social.facebook')}}" class="_link fb"><i></i></a>
                    <a href="{{config('social.google_plus')}}" class="_link gp"><i></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>