@extends('layouts.app')

@section('content')
<div class="page-default__inner">
    <div class="call-center">
        <div class="container">
            <div class="call-center__title">
                <h1>{{$category->title}}</h1>
            </div>
            <div class="call-center__label ">
                {!! $category->header_description !!}
            </div>
            @if(!empty(strip_tags($category->seo_header_description)))
            <div class="call-center__action">
                <button class="_btn js-open-call-center"><i></i><span class="_show">Show more</span><span class="_close">Close</span></button>
            </div>
            @endif

            <div class="block-open__filter">
                <button class="_btn js-open-filter btn btn-big btn-purple"><i></i><span class="_apply">Apply</span><span class="_open">Open filter</span><span class="_close">Close</span></button>
            </div>

        </div>
    </div>

    <div class="static js-text-call-center" style="display: none;">
        <div class="container">
            {!! $category->seo_header_description !!}
        </div>
    </div>


    <div class="container">
        <div class="relative">
            <div class="row">
                <aside class="col-lg-3 aside">
                    @include('sections.category.filter')
                </aside>

                <div class="col-lg-9 col-md-12">

                    @foreach($products as $item)
                        @include('sections.category.item', ['item' => $item])
                    @endforeach

                    @include('sections.category.baners')

                    {{$products->links()}}

                </div>


            </div>
        </div>

    </div>

    @include('sections.category.news_and_update', [
        'prods' => $products->pluck('id')
    ])
</div>
@endsection