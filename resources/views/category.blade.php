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
                <button class="_btn js-open-filter btn btn-big btn-purple" onclick="if($(this).hasClass('btn-apply')){$('#filter-form').submit(); return false;}"><i></i><span class="_apply" onclick="$('#filter-form').submit(); return false;">Apply</span><span class="_open">Open filter</span><span class="_close">Close</span></button>
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

                    @if(!$products->count())
                        <center>
                            <h2>No results were found for your search!</h2><br>
                            <a href="{{route('category', ['category' => $category->slug])}}" style="font-size: 16px;color: #7440b3;margin-bottom: 10px;">Clear the filter</a> <span>and try again</span>
                        </center>

                    @endif

                    @foreach($products as $item)
                        @include('sections.category.item', ['item' => $item])
                    @endforeach

                    @include('sections.category.baners')

                    {{$products->links()}}

                    @if(count($category->related_links))
                        @include('sections.category.related_links', ['links' => $category->related_links])
                    @endif

                </div>


            </div>
        </div>

    </div>

    @include('sections.category.news_and_update')
</div>
@endsection