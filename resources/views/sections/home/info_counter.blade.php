<div class="main-home__desc">
    <div class="_item">
        <div class="_img"><img src="{{asset('images/main-icons/icon_01.svg')}}" alt=""></div>
        <div class="_inner">
            <div class="_label">{{\App\Models\Categories::getCount()}}</div>
            <div class="_title">Software categories</div>
        </div>
    </div>

    <div class="_item">
        <div class="_img"><img src="{{asset('images/main-icons/icon_02.svg')}}" alt=""></div>
        <div class="_inner">
            <div class="_label">{{\App\Models\Products::all()->count()}}</div>
            <div class="_title">B-2-b solutions</div>
        </div>
    </div>

    <div class="_item">
        <div class="_img"><img src="{{asset('images/main-icons/icon_03.svg')}}" alt=""></div>
        <div class="_inner">
            <div class="_label">{{\App\Models\Reviews::where('status', 1)->count()}}</div>
            <div class="_title">Reviews</div>
        </div>
    </div>
</div>