@extends('layouts.app')

@section('content')
<div class="page-default__inner">
    <div class="call-center">
        <div class="container">
            <div class="call-center__title">
                <h1>Top software</h1>
            </div>
            <div class="call-center__label ">
                {{--{!! $category->header_description !!}--}}
            </div>
            <div class="call-center__action">
                {{--<button class="_btn js-open-call-center"><i></i><span class="_show">Show more</span><span class="_close">Close</span></button>--}}
            </div>

        </div>
    </div>


    <div class="container">
        <div class="relative">
            <div class="row">

                <div class="col-lg-12 col-md-12">

                    @foreach($products as $item)
                        @include('sections.category.item', ['item' => $item])
                    @endforeach

                    @include('sections.category.baners')

                    {{$products->links()}}

                </div>


            </div>
        </div>

    </div>

    @include('sections.home.news_and_update')
</div>
@endsection