@extends('layouts.app')

@section('content')

    <div class="page-default__inner">
        <div class="compare">
            <div class="container">
                <div class="compare-title">
                    <div class="_title">
                        {{$left->title}} vs {{$right->title}}
                        comparaison
                    </div>
                </div>
            </div>

            <div class="compare-main">
                <div class="container">
                    <div class="compare-main__inner">
                        <div class="compare-main__title">
                            <div class="_title">
                                <span>Software</span><br>
                                on radar
                            </div>
                        </div>

                        <div class="compare-main__body">
                            <div class="compare-main__compare">
                                <div class="compare-main__item">
                                    <div class="item-header">
                                        <div class="_logo"><a href="{{route('product', ['product' => $left->slug])}}"><img src="{{asset($left->logo)}}" width="40" alt="{{$left->title}}"></a></div>
                                        <div class="item-info__link red mobile"><a href="{{route('product', ['product' => $left->slug])}}" class="_link">{{$left->title}}</a></div>
                                        <div class="_rating">
                                            <div class="rating">
                                                <div class="rating__inner">
                                                    <div class="rating__info">
                                                        <div class="rating__label ">Average rating:</div>

                                                        <div class="rating__star ">
                                                            <div class="rating-star ">
                                                                <div class="rating-star__inner">
                                                                    <div class="rating-star__empty"></div>
                                                                    <div class="rating-star__fill" style="width: {{(100/5)*$left->review_rait_total}}%"></div>
                                                                </div>
                                                            </div>


                                                            <div class="rating__comment">
                                                                <div class="icon-comment">
                                                                    <i></i><a href="{{route('product.reviews', ['product' => $left->slug])}}">{{$left->review_count}}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="rating__total">
                                                        @php
                                                            $left_rev_rait = explode('.', $left->review_rait_total);
                                                        @endphp
                                                        <div class="rating-total__value {{$left->color}} ">
                                                            <span class="_label">{{$left_rev_rait[0]}}</span>{{isset($left_rev_rait[1]) ? '.'.substr($left_rev_rait[1], 0, 2) : ''}}/5
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="item-info">
                                        <div class="item-info__link red no-mobile"><a href="{{route('product', ['product' => $left->slug])}}" class="_link">{{$left->title}}</a></div>
                                        <div class="item-info__desc">{!! $left->short_description !!}</div>
                                    </div>
                                </div>
                                <div class="compare-main__vs">
                                    <span class="_text">vs</span> <span class="_line"></span>
                                </div>
                                <div class="compare-main__item">
                                    <div class="item-header">
                                        <div class="_logo"><a href="{{route('product', ['product' => $right->slug])}}"><img src="{{asset($right->logo)}}" width="40" alt="{{$right->title}}"></a></div>
                                        <div class="item-info__link orange mobile"><a href="{{route('product', ['product' => $right->slug])}}" class="_link">{{$right->title}}</a></div>
                                        <div class="_rating">
                                            <div class="rating">
                                                <div class="rating__inner">
                                                    <div class="rating__info">
                                                        <div class="rating__label ">Average rating:</div>

                                                        <div class="rating__star ">
                                                            <div class="rating-star ">
                                                                <div class="rating-star__inner">
                                                                    <div class="rating-star__empty"></div>
                                                                    <div class="rating-star__fill" style="width: {{(100/5)*$right->review_rait_total}}%"></div>
                                                                </div>
                                                            </div>


                                                            <div class="rating__comment">
                                                                <div class="icon-comment">
                                                                    <i></i><a href="{{route('product.reviews', ['product' => $right->slug])}}">{{$right->review_count}}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="rating__total">
                                                        @php
                                                            $right_rev_rait = explode('.', $right->review_rait_total);
                                                        @endphp
                                                        <div class="rating-total__value {{$right->color}} ">
                                                            <span class="_label">{{$right_rev_rait[0]}}</span>{{isset($right_rev_rait[1]) ? '.'.substr($right_rev_rait[1], 0, 2) : ''}}/5
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="item-info">
                                        <div class="item-info__link orange no-mobile"><a href="{{route('product', ['product' => $right->slug])}}" class="_link">{{$right->title}}</a></div>
                                        <div class="item-info__desc">{!! $right->short_description !!}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="compare-main__rating">
                                <div class="compare-main__rating-title">
                                    Software on radar
                                </div>
                                <div class="compare-main__chart js-chart" style="z-index: 1;">
                                    <div id="container" style="margin: 0 auto;"></div>
                                </div>
                                <div class="compare-main__rating-inner">


                                    <div class="item-rating">
                                        <div class="mobile">
                                            @php
                                                $left_rev_rait = explode('.', $left->review_rait_total);
                                            @endphp
                                            <div class="rating-total__value {{$left->color}} ">
                                                <span class="_label">{{$left_rev_rait[0]}}</span>{{isset($left_rev_rait[1]) ? '.'.substr($left_rev_rait[1], 0, 2) : ''}}/5
                                            </div>
                                            <div class="item-rating__title red">
                                                <span>{{$left->title}}</span>
                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label ">Easy-of-use:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star rating-star--small">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$left->review_count ? (100/5)*($left->easy_of_use/$left->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label ">Functionality:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star rating-star--small">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$left->review_count ? (100/5)*($left->functionality/$left->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label ">Product Quality:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star rating-star--small">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$left->review_count ? (100/5)*($left->product_quality/$left->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label ">Customer Support:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star rating-star--small">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$left->review_count ? (100/5)*($left->customer_support/$left->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label ">Value for Money:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star rating-star--small">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$left->review_count ? (100/5)*($left->value_for_money/$left->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="no-mobile">

                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label rating__label--big">Easy-of-use:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star ">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$left->review_count ? (100/5)*($left->easy_of_use/$left->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="rating__value">({{$left->review_count ? substr($left->easy_of_use/$left->review_count, 0, 3):0}})</div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label rating__label--big">Functionality:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star ">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$left->review_count ? (100/5)*($left->functionality/$left->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="rating__value">({{$left->review_count ? substr($left->functionality/$left->review_count, 0, 3):0}})</div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label rating__label--big">Product Quality:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star ">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$left->review_count ? (100/5)*($left->product_quality/$left->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="rating__value">({{$left->review_count ? substr($left->product_quality/$left->review_count, 0, 3):0}})</div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label rating__label--big">Customer Support:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star ">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$left->review_count ? (100/5)*($left->customer_support/$left->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="rating__value">({{$left->review_count ? substr($left->customer_support/$left->review_count, 0, 3):0}})</div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label rating__label--big">Value for Money:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star ">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$left->review_count ? (100/5)*($left->value_for_money/$left->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="rating__value">({{$left->review_count ? substr($left->value_for_money/$left->review_count, 0, 3):0}})</div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-rating right">
                                        <div class="mobile">
                                            @php
                                                $right_rev_rait = explode('.', $right->review_rait_total);
                                            @endphp
                                            <div class="rating-total__value {{$right->color}} ">
                                                <span class="_label">{{$right_rev_rait[0]}}</span>{{isset($right_rev_rait[1]) ? '.'.substr($right_rev_rait[1], 0, 2) : ''}}/5
                                            </div>
                                            <div class="item-rating__title orange">
                                                <span>{{$right->title}}</span>
                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label ">Easy-of-use:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star rating-star--small">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$right->review_count ? (100/5)*($right->easy_of_use/$right->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label ">Functionality:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star rating-star--small">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$right->review_count ? (100/5)*($right->functionality/$right->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label ">Product Quality:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star rating-star--small">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$right->review_count ? (100/5)*($right->product_quality/$right->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label ">Customer Support:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star rating-star--small">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$right->review_count ? (100/5)*($right->customer_support/$right->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label ">Value for Money:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star rating-star--small">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$right->review_count ? (100/5)*($right->value_for_money/$right->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="no-mobile">
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label rating__label--big">Easy-of-use:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star ">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$right->review_count ? (100/5)*($right->easy_of_use/$right->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="rating__value">({{$right->review_count ? substr($right->easy_of_use/$right->review_count, 0, 3):0}})</div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label rating__label--big">Functionality:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star ">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$right->review_count ? (100/5)*($right->functionality/$right->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="rating__value">({{$right->review_count ? substr($right->functionality/$right->review_count, 0, 3):0}})</div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label rating__label--big">Product Quality:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star ">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$right->review_count ? (100/5)*($right->product_quality/$right->review_count) : 0 }}%"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="rating__value">({{$right->review_count ? substr($right->product_quality/$right->review_count, 0, 3):0}})</div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label rating__label--big">Customer Support:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star ">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$right->review_count ? (100/5)*($right->customer_support/$right->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="rating__value">({{$right->review_count ? substr($right->customer_support/$right->review_count, 0, 3):0}})</div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="_item">
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">
                                                            <div class="rating__label rating__label--big">Value for Money:</div>

                                                            <div class="rating__star rating__star--mt">
                                                                <div class="rating-star ">
                                                                    <div class="rating-star__inner">
                                                                        <div class="rating-star__empty"></div>
                                                                        <div class="rating-star__fill" style="width: {{$right->review_count ? (100/5)*($right->value_for_money/$right->review_count) : 0}}%"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="rating__value">({{$right->review_count ? substr($right->value_for_money/$right->review_count, 0, 3):0}})</div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="compare-main__screen">
                        <div class="compare-main__screen-title">
                            <div class="_title">Screenshots</div>
                        </div>

                        <div class="compare-main__screen-body">
                            @if($left->images->count())
                            <div class="compare-main__screen-item">
                                <div class="screen-item" style="max-width: 372px">
                                    <a class="screen-item__img no-mobile" href="{{asset($left->images[0]->img)}}" data-fancybox="group1">
                                        <img src="{{asset($left->images[0]->img)}}" style="max-width: 372px" alt="">
                                        <div class="screen-item__action">
                                            <div class="_label">View {{$left->images->count()}} more</div>
                                        </div>
                                    </a>

                                    <a class="w100 btn btn-border mobile" href="{{asset($left->images[0]->img)}}" data-fancybox="group1">Screenshots</a>
                                </div>

                                <div hidden>
                                    @foreach($left->images as $img)
                                        @if($loop->iteration>1)
                                            <a href="{{asset($img->img)}}" data-fancybox="group1"></a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if($right->images->count())
                            <div class="compare-main__screen-item">
                                <div class="screen-item" style="max-width: 372px">
                                    <a class="screen-item__img no-mobile" href="{{asset($right->images[0]->img)}}" data-fancybox="group1">
                                        <img src="{{asset('images/screenshots/img_01.jpg')}}" style="max-width: 372px" alt="">
                                        <div class="screen-item__action">
                                            <div class="_label">View {{$right->images->count()}} more</div>
                                        </div>
                                    </a>

                                    <a class="w100 btn btn-border mobile" href="{{asset($right->images[0]->img)}}" data-fancybox="group2">Screenshots</a>
                                </div>

                                <div hidden>
                                    @foreach($right->images as $img)
                                        @if($loop->iteration>1)
                                            <a href="{{asset($img->img)}}" data-fancybox="group1"></a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="compare-table">
                <div class="container">
                    <div class="compare-table__inner" style="z-index: 2;">
                        <div class="compare-table__fixed">
                            <div class="_inner">
                                <div class="_item">
                                    <img src="{{asset($left->logo)}}" alt="">
                                    <span>{{$left->title}}</span>
                                </div>
                                <div class="_middle">vs</div>
                                <div class="_item">
                                    <img src="{{asset($right->logo)}}" alt="">
                                    <span>{{$right->title}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="compare-table__row compare-table__row--head">
                            <div class="_title">Typical customers</div>
                            <div class="_inner">
                                <div class="_status"></div>
                                <div class="_empty"></div>
                                <div class="_status"></div>
                            </div>
                        </div>
                        <div class="compare-table__row">
                            <div class="_title">Medium business</div>
                            <div class="_status"><i class="{{array_search('Medium', $left->details['business_size'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Medium', $right->details['business_size'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">Enterprise business</div>
                            <div class="_status"><i class="{{array_search('Enterprise', $left->details['business_size'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Enterprise', $right->details['business_size'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">Small business</div>
                            <div class="_status"><i class="{{array_search('Small', $left->details['business_size'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Small', $right->details['business_size'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row compare-table__row--head">
                            <div class="_title">Pricing</div>
                            <div class="_inner">
                                <div class="_status">
                                    <div class="_big">
                                        @if($left->pricing['starting_price']['onsubmit']=='off')
                                            <div class="_label">From ${{$left->pricing['starting_price']['price']}}/ agent</div>
                                        @else
                                            <div class="_label">On submit</div>
                                            <div class="_btn">
                                                <a href="{{$left->pricing['starting_price']['link']}}" class="btn btn-purple">Get price</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="_empty"></div>
                                <div class="_status">
                                    <div class="_big">
                                        @if($right->pricing['starting_price']['onsubmit']=='off')
                                            <div class="_label">From ${{$right->pricing['starting_price']['price']}}/ agent</div>
                                        @else
                                            <div class="_label">On submit</div>
                                            <div class="_btn">
                                                <a href="{{$right->pricing['starting_price']['link']}}" class="btn btn-purple">Get price</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="compare-table__row compare-table__row--head">
                            <div class="_title">Pricing model</div>
                            <div class="_inner">
                                <div class="_status"></div>
                                <div class="_empty"></div>
                                <div class="_status"></div>
                            </div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">Subscription</div>
                            <div class="_status"><i class="{{array_search('Subscription', $left->pricing['pricing_model'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Subscription', $right->pricing['pricing_model'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">Pay as you go</div>
                            <div class="_status"><i class="{{array_search('Pay as you go', $left->pricing['pricing_model'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Pay as you go', $right->pricing['pricing_model'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">No Seat Price</div>
                            <div class="_status"><i class="{{array_search('No Seat Price', $left->pricing['pricing_model'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('No Seat Price', $right->pricing['pricing_model'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>


                        <div class="compare-table__row compare-table__row--head">
                            <div class="_title">Free trial</div>

                            <div class="_inner">
                                <div class="_status {{$left->pricing['free_trial']['active']!='on' ? '_status--icon':''}}">
                                    @if($left->pricing['free_trial']['active']!='on')
                                        <i class="icon-mark-minus"></i>
                                    @else
                                        <div class="_big">
                                            <div class="_label no-mobile">
                                                <i class="icon-mark"></i>
                                            </div>
                                            <div class="_btn">
                                                <a href="{{$left->pricing['free_trial']['link']}}" class="btn btn-purple">Get free trial</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="_empty"></div>
                                <div class="_status {{$right->pricing['free_trial']['active']!='on' ? '_status--icon':''}}">
                                    @if($right->pricing['free_trial']['active']!='on')
                                        <i class="icon-mark-minus"></i>
                                    @else
                                        <div class="_big">
                                            <div class="_label no-mobile">
                                                <i class="icon-mark"></i>
                                            </div>
                                            <div class="_btn">
                                                <a href="{{$right->pricing['free_trial']['link']}}" class="btn btn-purple">Get free trial</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="compare-table__row compare-table__row--head">
                            <div class="_title">Training</div>
                            <div class="_status"></div>
                            <div class="_empty"></div>
                            <div class="_status"></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">Documanetation</div>
                            <div class="_status"><i class="{{array_search('Documenation', $left->pricing['training'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Documenation', $right->pricing['training'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>


                        <div class="compare-table__row">
                            <div class="_title">Webinars</div>
                            <div class="_status"><i class="{{array_search('Webinars', $left->pricing['training'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Webinars', $right->pricing['training'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">In person</div>
                            <div class="_status"><i class="{{array_search('In person', $left->pricing['training'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('In person', $right->pricing['training'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">Live courses</div>
                            <div class="_status"><i class="{{array_search('Live courses', $left->pricing['training'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Live courses', $right->pricing['training'])!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row compare-table__row--head">
                            <div class="_title">Features</div>
                            <div class="_status"></div>
                            <div class="_empty"></div>
                            <div class="_status"></div>
                        </div>


                        @foreach($compare->category->categories_ff as $f)
                        <div class="compare-table__row">
                            <div class="_title">{{$f->title}}</div>
                            <div class="_status"><i class="{{array_search($f->title, array_collapse($left->features))!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search($f->title, array_collapse($right->features))!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>
                        @endforeach


                        <div class="compare-table__row compare-table__row--head">
                            <div class="_title">Features</div>
                            <div class="_status"></div>
                            <div class="_empty"></div>
                            <div class="_status"></div>
                        </div>

                        <div class="compare-table__row compare-table__row--label">
                            <div class="_title">Deployment:</div>
                            <div class="_status"></div>
                            <div class="_empty"></div>
                            <div class="_status"></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">SaaS</div>
                            <div class="_status"><i class="{{array_search('SaaS', $left->deployment)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('SaaS', $right->deployment)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">InHouse</div>
                            <div class="_status"><i class="{{array_search('InHouse', $left->deployment)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('InHouse', $right->deployment)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row compare-table__row--label">
                            <div class="_title">Desktop client:</div>
                            <div class="_status"></div>
                            <div class="_empty"></div>
                            <div class="_status"></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">Windows</div>
                            <div class="_status"><i class="{{array_search('Windows', $left->desc_client)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Windows', $right->desc_client)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">Mac</div>
                            <div class="_status"><i class="{{array_search('Mac', $left->desc_client)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Mac', $right->desc_client)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>


                        <div class="compare-table__row">
                            <div class="_title">Linux</div>
                            <div class="_status"><i class="{{array_search('Linux', $left->desc_client)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Linux', $right->desc_client)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">Web-browser</div>
                            <div class="_status"><i class="{{array_search('Web-browser', $left->desc_client)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Web-browser', $right->desc_client)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row compare-table__row--label">
                            <div class="_title">Mobile version:</div>
                            <div class="_status"></div>
                            <div class="_empty"></div>
                            <div class="_status"></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">Android</div>
                            <div class="_status"><i class="{{array_search('Android', $left->mobile_version)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Android', $right->mobile_version)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">IOS</div>
                            <div class="_status"><i class="{{array_search('IOS', $left->mobile_version)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('IOS', $right->mobile_version)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>


                        <div class="compare-table__row">
                            <div class="_title">Windows phone</div>
                            <div class="_status"><i class="{{array_search('Windows phone', $left->mobile_version)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Windows phone', $right->mobile_version)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row">
                            <div class="_title">Web-browser</div>
                            <div class="_status"><i class="{{array_search('Web-browser', $left->mobile_version)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                            <div class="_empty"></div>
                            <div class="_status"><i class="{{array_search('Web-browser', $right->mobile_version)!==false ? 'icon-mark':'icon-mark-minus'}}"></i></div>
                        </div>

                        <div class="compare-table__row compare-table__row--last">
                            <div class="_title"></div>
                            <div class="_status"></div>
                            <div class="_empty"></div>
                            <div class="_status"></div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $similar = \App\Models\Compares::with('left', 'right')->where(function($q) use ($left){
                    $q->orWhere('product_left_id', $left->id)->orWhere('product_right_id', $left->id);
                })->where('id', '!=', $compare->id)->take(4)->get();
            @endphp
            @if(count($similar))
            <section class="section">
                <div class="container">
                    <div class="section__inner">
                        <div class="section__title">
                            <h2 class="h2">Also you may be interested</h2>
                        </div>

                        <div class="section__body">
                            <div class="compare-list">
                                <div class="compare-list__row">
                                    @foreach($similar as $sim)
                                    <div class="compare-list__col">
                                        <div class="compare-list__item">
                                            <a href="{{route('compare', ['compare' => $sim->slug])}}" class="compare-list__link"></a>
                                            <div class="header-logo-compare">
                                                <div class="item-logo">
                                                    <img src="{{asset($sim->left->logo)}}" alt="{{$sim->left->title}}">
                                                </div>
                                                <div class="item-title">{{$sim->left->title}}</div>
                                            </div>

                                            <div class="item-vs"><span class="_text">vs</span> <span class="_line"></span></div>
                                            <div class="item-compare">
                                                <div class="_info">
                                                    <span class="_logo"><img src="{{asset($sim->right->logo)}}" alt="{{$sim->right->title}}"></span>
                                                    <span class="_title">{{$sim->right->title}}</span>
                                                </div>
                                            </div>
                                            <div class="item-rating">
                                                <div class="_rating">Rating:</div>
                                                <div class="rating">
                                                    <div class="rating__inner">
                                                        <div class="rating__info">

                                                            <div class="rating__star ">
                                                                <div class="rating-star ">
                                                                    <i {{round($sim->right->review_rait_total)>=1 ? 'class=fill' : ''}}></i>
                                                                    <i {{round($sim->right->review_rait_total)>=2 ? 'class=fill' : ''}}></i>
                                                                    <i {{round($sim->right->review_rait_total)>=3 ? 'class=fill' : ''}}></i>
                                                                    <i {{round($sim->right->review_rait_total)>=4 ? 'class=fill' : ''}}></i>
                                                                    <i {{round($sim->right->review_rait_total)>=5 ? 'class=fill' : ''}}></i>
                                                                </div>

                                                                <div class="rating__value">{{round($sim->right->review_rait_total)}}</div>

                                                                <div class="rating__comment">
                                                                    <div class="icon-comment">
                                                                        <i></i><a href="{{route('product.reviews', ['product' => $sim->right->slug])}}">{{$sim->right->review_count}}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="section__action section__action--center">
                            <a href="{{route('product.compare', ['product' => $left->slug])}}" class="btn btn-border btn-radius btn-radius--big btn-big compare-list__btn">
                                All comparasions with {{$left->title}}
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script>
    var categoriesChart = {0:'Easy-of-use', 72:'Functionality', 144:'Product Quality', 216:'Customer Support', 288:'Value for Money'};
    Highcharts.chart('container', {
        chart: {
            polar: true
        },
        title: {
            text: ''
        },
        pane: {
            startAngle: 0,
            endAngle: 360
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        xAxis: {
            tickInterval: 72,
            min: 0,
            max: 360,
            labels: {
                rotation: 'auto',
                align: 'center',
                enabled: true,
                formatter: function () {
                    return categoriesChart[this.value];
                }
            }
        },
        yAxis: {
            min: 0,
            visible: false
        },
        plotOptions: {
            series: {
                pointStart: 0,
                pointInterval: 72
            },
            column: {
                pointPadding: 0,
                groupPadding: 0
            }
        },

        tooltip: {
            formatter: function() {
                return categoriesChart[this.x] + '<br><span style="fill:'+this.color+'">●</span> '+ this.series.name + ' :<b>'+this.y+'</b>';
            }
        },

        series: [
            {
                type: 'line',
                name: '{{$right->title}}',
                data: [
                    {{$right->review_count ? substr($right->easy_of_use/$right->review_count, 0, 3):0}},
                    {{$right->review_count ? substr($right->functionality/$right->review_count, 0, 3):0}},
                    {{$right->review_count ? substr($right->product_quality/$right->review_count, 0, 3):0}},
                    {{$right->review_count ? substr($right->customer_support/$right->review_count, 0, 3):0}},
                    {{$right->review_count ? substr($right->value_for_money/$right->review_count, 0, 3):0}}
                ],
                lineColor: "#efc92b",
                color: "#efc92b"
            },
            {
                type: 'area',
                name: '{{$left->title}}',
                data: [
                    {{$left->review_count ? substr($left->easy_of_use/$left->review_count, 0, 3):0}},
                    {{$left->review_count ? substr($left->functionality/$left->review_count, 0, 3):0}},
                    {{$left->review_count ? substr($left->product_quality/$left->review_count, 0, 3):0}},
                    {{$left->review_count ? substr($left->customer_support/$left->review_count, 0, 3):0}},
                    {{$left->review_count ? substr($left->value_for_money/$left->review_count, 0, 3):0}}
                ],
                lineColor: "#ff1b4b",
                fillColor: "rgba(255,27,75,0.2)",
                color: "#ff1b4b"
            }
        ]
    });

</script>
@endpush