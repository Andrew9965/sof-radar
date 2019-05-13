@extends('layouts.app')

@section('content')
    <div class="page-default__inner">
        <div class="breadcrumbs ">
            <div class="container">
                <div class="breadcrumbs-inner">
                    <a href="{{route('product', ['product' => $product->slug])}}">{{mb_strimwidth($product->title, 0, 30, "...")}}</a>
                </div>

                <div class="breadcrumbs-inner">
                    <a href="{{route('product.news', ['product' => $product->slug])}}">News and updates</a>
                </div>

                <div class="breadcrumbs-inner">
                    <span>{{mb_strimwidth($new->title, 0, 80, "...")}}</span>
                </div>
            </div>
        </div>
        <div class="news">
            <div class="container">

                <div class="news__date">
                    <span>{{Date\DateFormat::post($new->created_at)}}</span>
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        <div class="news__main">
                            <div class="news__title">
                                <h2 class="h2">{{$new->title}}</h2>
                            </div>

                            <div class="news__desc">{!! $new->text !!}</div>

                            {!! $new->description !!}

                            {{--
                            <div class="quote">
                                <div class="quote__inner">
                                    <div class="quote__author">
                                        <div class="quote__img"><img src="{{asset('images/avatar/img_01.png')}}" alt=""></div>
                                        <div class="quote__author-inner">
                                            <div class="quote__name">Oleg Kravchenko</div>
                                            <div class="quote__position">deputy director general at CROC</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            --}}
                        </div>

                    </div>
                    @include('sections.new.new_left')
                </div>
            </div>

        </div>


        <section class="section contact-center">
            <div class="container">
                <div class="section__inner">
                    @php
                        $news_all = collect($product->news)->sortByDesc('created_at')->where('id','!=',$new->id);
                        $news = $news_all->take(3);
                    @endphp
                    <div class="section__title">
                        <h2 class="h2">{{$product->title}} News and updates</h2>
                    </div>

                    <div class="section__body">
                        <div class="row">
                            @php $lg = count($news)==3 ? 4 : (count($news)==2 ? 6 : 12); @endphp
                            @foreach($news as $new)
                                <div class="col-lg-{{$lg}} contact-center__col">
                                    <div class="contact-center__item">
                                        <div class="_date">{{Date\DateFormat::post($new->created_at)}}</div>
                                        <div class="_title"><a href="{{route('product.new', ['product' => $product->slug, 'product_new' => $new->id])}}">{{$new->title}}</a></div>
                                        <div class="_desc"><a href="{{route('product.new', ['product' => $product->slug, 'product_new' => $new->id])}}">{!! $new->text !!}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="section__action section__action--center">
                        <a href="{{route('product.news', ['product' => $product->slug])}}" class="btn btn-border btn-radius btn-radius--big btn-big">All news</a>
                    </div>
                </div>
            </div>
        </section>    <section class="section section--pink">
            <div class="container">
                <div class="section__inner">
                    <div class="section__title">
                        <h2 class="h2">Recomended software</h2>
                    </div>

                    <div class="section__body">
                        <div class="_row row">
                            @foreach(\App\Models\Products::take(4)->orderBy('created_at', 'desc')->get() as $soft)
                                @include('sections.soft.soft_item', ['soft' => $soft])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>  </div>
@endsection