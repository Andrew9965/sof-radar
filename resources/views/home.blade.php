@extends('layouts.app')

@section('content')
<div class="page-default__inner">
    <div class="main-home">
        <div class="container">
            <div class="main-home__title">
                <h1 class="h1">Soft Radar - ваш навигатор в мире B2B software</h1>
            </div>
            <div class="main-home__label">
                Помогаем узнать, сравнить, и выбрать лучшее решение для компании small, mediuma or large enterprise сегмента
            </div>

            <div class="main-home__search">
                <div class="page-search">
                    <div class="page-search__inner">
                        <div class="_label">Searсh:</div>
                        <div class="_input">
                            <input type="text" placeholder="B2B-software" id="live_search">
                        </div>
                        <div class="_action">
                            <button class="_btn js-open-search"><i></i></button>
                        </div>
                    </div>

                    <div class="page-search__menu">
                        <div class="page-search__menu-inner">
                        </div>
                        <div class="page-search__menu-action">
                            <button class="_btn js-close-search"><i></i></button>
                        </div>
                    </div>
                    <button class="_action mobile js-close-search mobile btn-close">Close</button>
                </div>
            </div>

            @include('sections.home.info_counter')
        </div>
    </div>

    @include('sections.home.top_categories')

    @include('sections.home.top_soft')

    <section class="section section--shadow section--gray-light">
        <div class="container">
            <div class="section__inner">
                <div class="section__title">
                    <h2 class="h2">Latest reviews</h2>
                </div>
                <div class="section__body">
                    @foreach(\App\Models\Reviews::orderBy('created_at', 'desc')->whereHas('product')->where('status',1)->take(2)->get() as $r)
                    <div class="_row row">
                        <div class="col-md-12">
                            @include('sections.soft.review_item', ['r' => $r, 'fool' => true])
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="section__action section__action--center">
                    <button class="btn btn-border btn-radius btn-radius--big btn-big" data-popup="add-review">Add reviews</button>
                </div>
            </div>
        </div>
    </section>

    @include('sections.home.news_and_update')


    <section class="section section-about">
        <div class="container">
            <div class="section__inner">
                <div class="section__title">
                    <h2 class="h2 h2--bold h2--purple">About SoftRadar.net</h2>
                </div>
                <div class="section__body">
                    <div class="_text">{{config('about')}}</div>

                    <div class="section-about__logo">
                        <span class="_label">Featured by:</span>
                        <div class="_logo">
                            <img src="{{asset('images/about-logo/img_01.png')}}" alt="">
                            <img src="{{asset('images/about-logo/img_02.png')}}" alt="">
                            <img src="{{asset('images/about-logo/img_03.png')}}" alt="">
                            <img src="{{asset('images/about-logo/img_04.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection