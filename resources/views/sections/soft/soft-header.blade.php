@php
    $rev_count = $product->review_count;
    $route = Route::currentRouteName();

    $m_count = $product->media->count();
    $r_count = $product->reviews->count();
    $n_count = $product->news->count();
    $a_count = $product->alternatives();
    $c_count = $a_count; //$product->compression();

@endphp
<div class="page-nav hidden-md">
    <div class="container">
        <div class="page-nav__inner">
            <div class="page-nav__list">

                <div class="page-nav__header">
                    @if($route=='product')
                        <a><span>Overview</span></a>
                    @elseif($route=='product.media')
                        <a><span>Screenshots/Video ({{$m_count}})</span></a>
                    @elseif($route=='product.reviews')
                        <a><span>Reviews ({{$r_count}})</span></a>
                    @elseif($route=='product.news')
                        <a><span>News and updates ({{$n_count}})</span></a>
                    @elseif($route=='product.alternative')
                        <a><span>Alternatives ({{$a_count}})</span></a>
                    @elseif($route=='product.compare')
                        <a><span>Comparisons {{$c_count}}</span></a>
                    @endif

                </div>

                <div class="page-nav__toggle">
                    <div class="page-nav__item {{$route=='product' ? 'active':''}}">
                        <a href="{{route('product', ['product' => $product->slug])}}" class="_link">Overview</a>
                    </div>
                    <div class="page-nav__item {{$route=='product.media' ? 'active':''}} {{$product->media->count() ? '' : 'empty'}}">
                        @if($m_count)
                            <a href="{{route('product.media', ['product' => $product->slug])}}" class="_link">Screenshots/Video <span>({{$m_count}})</span></a>
                        @else
                            <a href="#" class="_link">Screenshots/Video <span>({{$m_count}})</span></a>
                        @endif
                    </div>
                    <div class="page-nav__item {{$route=='product.reviews' ? 'active':''}} {{$product->reviews->count() ? '' : 'empty'}}">
                        @if($r_count)
                            <a href="{{route('product.reviews', ['product' => $product->slug])}}" class="_link">Reviews <span>({{$r_count}})</span></a>
                        @else
                            <a href="#" class="_link">Reviews <span>({{$r_count}})</span></a>
                        @endif
                    </div>
                    <div class="page-nav__item {{$route=='product.news' ? 'active':''}} {{$product->news->count() ? '' : 'empty'}}">
                        @if($n_count)
                            <a href="{{route('product.news', ['product' => $product->slug])}}" class="_link">News and updates <span>({{$n_count}})</span></a>
                        @else
                            <a href="#" class="_link">News and updates <span>({{$n_count}})</span></a>
                        @endif
                    </div>
                    <div class="page-nav__item {{$route=='product.alternative' ? 'active':''}} {{$product->alternatives() ? '' : 'empty'}}">
                        @if($a_count)
                            <a href="{{route('product.alternative', ['product' => $product->slug])}}" class="_link">Alternatives <span>({{$a_count}})</span></a>
                        @else
                            <a href="#" class="_link">Alternatives <span>({{$a_count}})</span></a>
                        @endif
                    </div>
                    <div class="page-nav__item {{$route=='product.compare' ? 'active':''}} {{$product->compression() ? '' : 'empty'}}">
                        @if($c_count)
                            <a href="{{route('product.compare', ['product' => $product->slug])}}" class="_link">Comparisons <span>({{$c_count}})</span></a>
                        @else
                            <a href="#" class="_link">Comparisons <span>({{$c_count}})</span></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-main">
    <div class="container">
        {{--<input type="checkbox" checked>--}}
        <div class="product-main__inner">
            <div class="product-main__header"><div class="_logo"><img src="{{asset($product->logo)}}" alt="" width="73"></div></div>
            <div class="product-main__body">
                <div class="product-main__name">
                    <div class="_title">{{$product->title}}</div>
                    <div class="_info">
                        @if(!empty($product->company)) <div class="_company">by {{$product->company}}</div> @endif
                        <div class="_label">
                            @foreach($categories->whereIn('id', $product->categories)->all() as $cat)
                            <span><a href="{{route('category', ['categories' => $cat->slug])}}">{{$cat->title}}</a></span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="product-main__footer hidden-md hidden-sm">
                    <div class="_label">{!! $product->short_description !!}</div>
                </div>
                @php
                    $rev_rait_total = $product->review_rait_total;
                    $rev_rait = explode('.', $rev_rait_total);
                @endphp
                <div class="product-main__rating">
                    <div class="rating">
                        <div class="rating__inner">
                            <div class="rating__info">
                                <div class="rating__label ">Average rating:</div>

                                <div class="rating__star ">
                                    <div class="rating-star ">
                                        <div class="rating-star__inner">
                                            <div class="rating-star__empty"></div>
                                            <div class="rating-star__fill" style="width: {{(100/5)*$rev_rait_total}}%"></div>
                                        </div>
                                    </div>


                                    <div class="rating__comment">
                                        <div class="icon-comment">
                                            <i></i><a href="{{route('product.reviews', ['product' => $product->slug])}}">{{$rev_count}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rating__total">
                                <div class="rating-total__value {{$product->color}} ">
                                    <span class="_label">{{$rev_rait[0]}}</span>{{isset($rev_rait[1]) ? '.'.substr($rev_rait[1], 0, 2) : ''}}/5
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="_action">
                        @if($product->is_click)
                            <a href="{{route('product.link', ['product' => $product->slug])}}" target="_blank" class="_btn btn btn-purple btn-middle">Visit Website</a>
                        @endif
                </div>
            </div>

            <div class="product-main__footer">
                <div class="_info">
                    <div class="_label  hidden-xs">{!! $product->short_description !!}</div>
                    <div class="input-slider">
                        <input type="checkbox" class="_input" {{$used->where('product_id',$product->id)->count() ? 'checked' : ''}} data-prod-title="{{$product->title}}" data-uses="{{$product->slug}}" id="input-slider">
                        <label for="input-slider" class="_label">i already use</label>
                    </div>
                </div>
                <div class="_banner">
                    {!! banner('product') !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-nav hidden-sm hidden-xs">
    <div class="container">
        <div class="page-nav__inner">
            <div class="page-nav__list">
                <div class="page-nav__item {{$route=='product' ? 'active':''}}">
                    <a href="{{route('product', ['product' => $product->slug])}}" class="_link">Overview</a>
                </div>
                <div class="page-nav__item {{$route=='product.media' ? 'active':''}} {{$product->media->count() ? '' : 'empty'}}">
                    @if($m_count)
                        <a href="{{route('product.media', ['product' => $product->slug])}}" class="_link">Screenshots/Video <span>({{$m_count}})</span></a>
                    @else
                        <a href="#" class="_link">Screenshots/Video <span>({{$m_count}})</span></a>
                    @endif
                </div>
                <div class="page-nav__item {{$route=='product.reviews' ? 'active':''}} {{$product->reviews->count() ? '' : 'empty'}}">
                    @if($r_count)
                        <a href="{{route('product.reviews', ['product' => $product->slug])}}" class="_link">Reviews <span>({{$r_count}})</span></a>
                    @else
                        <a href="#" class="_link">Reviews <span>({{$r_count}})</span></a>
                    @endif
                </div>
                <div class="page-nav__item {{$route=='product.news' ? 'active':''}} {{$product->news->count() ? '' : 'empty'}}">
                    @if($n_count)
                        <a href="{{route('product.news', ['product' => $product->slug])}}" class="_link">News and updates <span>({{$n_count}})</span></a>
                    @else
                        <a href="#" class="_link">News and updates <span>({{$n_count}})</span></a>
                    @endif
                </div>
                <div class="page-nav__item {{$route=='product.alternative' ? 'active':''}} {{$product->alternatives() ? '' : 'empty'}}">
                    @if($a_count)
                        <a href="{{route('product.alternative', ['product' => $product->slug])}}" class="_link">Alternatives <span>({{$a_count}})</span></a>
                    @else
                        <a href="#" class="_link">Alternatives <span>({{$a_count}})</span></a>
                    @endif
                </div>
                <div class="page-nav__item {{$route=='product.compare' ? 'active':''}} {{$product->compression() ? '' : 'empty'}}">
                    @if($c_count)
                        <a href="{{route('product.compare', ['product' => $product->slug])}}" class="_link">Comparisons <span>({{$c_count}})</span></a>
                    @else
                        <a href="#" class="_link">Comparisons <span>({{$c_count}})</span></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>