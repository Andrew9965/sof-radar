@extends('layouts.app')

@section('content')
    <div class="page-default__inner">
        <div class="breadcrumbs">
            <div class="container">
                <div class="breadcrumbs-inner">
                    <span>Categories</span>
                </div>
            </div>
        </div>
        <div class="news">
            <div class="container">
                <div class="relative">
                    <div class="page-search__menu-inner js-custom-scroll">
                        @foreach(\App\Models\CategoryType::where('active', 1)->get() as $type)
                        <div class="_item">
                            <div class="_img"><img src="{{asset('uploads/'.$type->logo)}}" alt="{{$type->title}}"></div>
                            <div class="_title">{{$type->title}}</div>
                            <div class="_list">
                                @if(isset($categoriesGroup[$type->id]))
                                    @foreach($categoriesGroup[$type->id] as $cat)
                                     <div class="_link"><a href="{{route('category', ['categories' => $cat['slug']])}}">{{$cat['title']}}</a></div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('sections.home.news_and_update')

@endsection