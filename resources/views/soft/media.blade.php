@extends('layouts.soft')

@section('soft-content')
    @php
        $medias = collect($product->media);
    @endphp

    <section class="section section--no_p-b">
        <div class="container">
            <div class="section__inner">
                <div class="section__title">
                    <h1 class="h2">All {{$product->title}} screenshots & videos</h1>
                </div>
                @if(count($slider = $medias->where('slider',1)->all()))
                <div class="section__body">
                    <div class="media-slider">
                        <div class="media-slider__inner">
                            <div class="media-slider__view js-media-slider-for">
                                @foreach($slider as $media)
                                    @if($media->type!='video')
                                        <div class="media-slider__item">
                                            <div class="media-slider__item-inner">
                                                <img src="{{asset($media->data)}}" alt="{{$media->title}}">
                                            </div>
                                        </div>
                                    @else
                                        <div class="media-slider__item">
                                            <div class="media-slider__item-inner">
                                                <div class="_video">
                                                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{array_last(explode('v=', $media->data))}}" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="media-slider__label">Topics of calls screen</div>

                            <div class="media-slider__nav js-media-slider-nav">
                                @foreach($medias->where('slider',1)->all() as $media)
                                <div class="media-slider__nav-item">
                                    <img src="{{asset($media->preview)}}" alt="{{$media->title}}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    @if(count($imgs = $medias->where('type','img')->where('slider', 0)->all()))
    <section class="section section--no_p-b">
        <div class="container">
            <div class="section__inner">
                <div class="section__title">
                    <h2 class="h2">Main features</h2>
                </div>
                <div class="section__body">

                    <div class=" row">
                        @foreach($imgs as $media)
                        <div class="col-lg-4 col-sm-6">
                            <div class="media-item">
                                <a class="media-item__img" href="{{asset($media->data)}}" data-fancybox="">
                                    <img src="{{asset($media->data)}}" alt="{{$media->title}}">
                                    <button class="_action"></button>
                                </a>
                                <div class="media-item__title">{{$media->title}}</div>
                                <div class="media-item__desc">{!! $media->description !!}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>


                </div>
            </div>
        </div>
    </section>
    @endif

    @php $videos = $medias->where('type','video')->where('slider', 0)->all(); @endphp

    @if(count($videos))
    <section class="section">
        <div class="container">
            <div class="section__inner">
                <div class="section__title">
                    <h2 class="h2">Videos</h2>
                </div>
                <div class="section__body">
                    <div class="row">
                        @foreach($videos as $video)
                        <div class="col-lg-6">
                            <div class="video">
                                <div class="video__view">
                                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{array_last(explode('v=', $video->data))}}" frameborder="0" gesture="media" allowfullscreen></iframe>
                                </div>
                                <div class="video__title">{{$video->title}}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <section class="section"></section>
@endsection