@extends('layouts.soft')


@section('soft-content')
    <div class="product-about">
        <div class="container">
            <div class="product-about__inner">
                <div class="product-about__info">
                    <div class="_title">About {{$product->title}}</div>
                    <div class="_desc box-gradient js-read-more-box">{!! $product->fool_description !!}</div>
                    <div class="_action">
                        <button class="read-more js-read-more-btn"><i></i>Read more</button>
                    </div>
                </div>
                @php
                $simProds = \App\Models\Products::where(function($q) use ($product){
                    $q->orWhere('category_1', $product->categories[1]);
                    $q->orWhere('category_2', $product->categories[1]);
                    $q->orWhere('category_3', $product->categories[1]);
                })->where('id','!=',$product->id)->take(5)->orderBy('review_rait_total', 'desc')->get();

                $p1 = $simProds->where('web_site', '!=', '')->all();
                $p2 = $simProds->where('web_site', '==', '')->all();

                $simProds = (new Illuminate\Database\Eloquent\Collection)->merge($p1)->merge($p2);

                @endphp
                @if($simProds->count())
                <div class="product-about__similar">
                    <div class="similar">
                        <div class="similar__inner">
                            <div class="similar__title">Similar software</div>
                            <div class="similar__list">
                                @foreach($simProds as $m)
                                    @php
                                        $rev_count = $m->review_count;
                                        $m_rait_total = $m->review_rait_total;
                                    @endphp
                                <div class="similar__item">
                                    <div class="_logo"><a href="{{route('product', ['product' => $m->slug])}}"><img src="{{asset($m->logo)}}" alt="" width="35"></a></div>
                                    <div class="_title"><a href="{{route('product', ['product' => $m->slug])}}">{{$m->title}}</a></div>
                                    <div class="_action">
                                        <div class="_rating">
                                            <div class="rating">
                                                <div class="rating__inner">
                                                    <div class="rating__info">

                                                        <div class="rating__star rating__star--mw">
                                                            <div class="rating-star ">
                                                                <div class="rating-star__inner">
                                                                    <div class="rating-star__empty"></div>
                                                                    <div class="rating-star__fill" style="width: {{(100/5)*$m_rait_total}}%"></div>
                                                                </div>
                                                            </div>

                                                            <div class="rating__value">{{substr($m_rait_total, 0, 3)}}/5</div>

                                                            <div class="rating__comment">
                                                                <div class="icon-comment">
                                                                    <i></i><a href="{{route('product', ['product' => $m->slug])}}">{{$m->reviews->count()}}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="_btn">
                                            <a class="btn-compare" href="{{route('compare.new', ['left' => $product->id, 'right' => $m->id])}}"><i></i>Comparison</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="similar__action">
                                <a href="{{route('product.alternative', ['product' => $product->slug])}}" class="_btn btn btn-border">All Similar Solutions</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @php

        $rev_count = $product->review_count;

    @endphp

    @if($cat = $categories->where('id', $product->categories[1])->first())
        <section class="section">
            <div class="container">
                <div class="section__inner">
                    <div class="section__title">
                        <h2 class="h2">{{$cat->title}}</h2>
                    </div>
                    <div class="section__body">
                        <div class="section__list  js-list-more">
                            @php $c_count = $cat->categories_ff; @endphp
                            <div class="section__list-inner js-list-more-box @if($c_count->count()>10) gradient_ff @endif">
                                <div class="container">
                                    <ul class="mark-list row">
                                        @foreach($c_count as $ff)
                                            @php $select = $product->features[1]; @endphp
                                            <li class="col-lg-3 col-sm-6 {{array_search($ff->title, $product->features[1])===false ? "_error":""}}">{{$ff->title}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @if($c_count->count()>10)
                            <div class="section__list-action">
                                <button class="read-more js-list-more-btn"><i></i>All contact center features</button>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(isset($product->categories[2]) && $cat = $categories->where('id', $product->categories[2])->first())
        <section class="section">
            <div class="container">
                <div class="section__inner">
                    <div class="section__title">
                        <h2 class="h2">{{$cat->title}}</h2>
                    </div>
                    <div class="section__body">
                        <div class="section__list  js-list-more">
                            @php $c_count = $cat->categories_ff; @endphp
                            <div class="section__list-inner js-list-more-box @if($c_count->count()>10) gradient_ff @endif">
                                <div class="container">
                                    <ul class="mark-list row">
                                        @foreach($c_count as $ff)
                                            @php $select = $product->features[2]; @endphp
                                            <li class="col-lg-3 col-sm-6 {{array_search($ff->title, $product->features[2])===false ? "_error":""}}">{{$ff->title}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @if($c_count->count()>10)
                            <div class="section__list-action">
                                <button class="read-more js-list-more-btn"><i></i>All contact center features</button>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(isset($product->categories[3]) && $cat = $categories->where('id', $product->categories[3])->first())
        <section class="section">
            <div class="container">
                <div class="section__inner">
                    <div class="section__title">
                        <h2 class="h2">{{$cat->title}}</h2>
                    </div>
                    <div class="section__body">
                        <div class="section__list  js-list-more">
                            @php $c_count = $cat->categories_ff; @endphp
                            <div class="section__list-inner js-list-more-box @if($c_count->count()>10) gradient_ff @endif">
                                <div class="container">
                                    <ul class="mark-list row">
                                        @foreach($c_count as $ff)
                                            @php $select = $product->features[3]; @endphp
                                            <li class="col-lg-3 col-sm-6 {{array_search($ff->title, $product->features[3])===false ? "_error":""}}">{{$ff->title}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @if($c_count->count()>10)
                            <div class="section__list-action">
                                <button class="read-more js-list-more-btn"><i></i>All contact center features</button>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endif

    <div class="product-pricing">
        <div class="container">
            <div class="product-pricing__inner">
                <div class="product-pricing__info">
                    <div class="product-pricing__title section__title"><h2 class="h2">Pricing</h2></div>
                    <div class="product-pricing__label">
                        <div class="_item">
                            <div class="_title">Starting price</div>
                            <div class="_label">
                                @if($product->pricing['starting_price']['onsubmit']=='off')
                                    ${{empty($product->pricing['starting_price']['price']) ? '0.00' : $product->pricing['starting_price']['price']}} / agent
                                @else
                                    <div>On submit</div>
                                    @if($product->is_web_click && $product->starting_price_link)
                                        <div class="_action">
                                            <a href="{{$product->starting_price_link}}" target="_blank" class="_btn btn btn-purple">Get price</a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="_item">
                            <div class="_title">Pricing model:</div>
                            <div class="_label">
                                @foreach($product->pricing['pricing_model'] as $pm)
                                <div class="_link">{{$pm}}</div>
                                @endforeach
                            </div>
                        </div>
                        <div class="_item">
                            <div class="_title">Training:</div>
                            <div class="_label">
                                @foreach($product->pricing['training'] as $tr)
                                <div class="_link">{{$tr}}</div>
                                @endforeach
                            </div>
                        </div>
                        @if($product->pricing['license_price']['onsubmit'] == 'on')
                        <div class="_item _item--btn">
                            <div class="_title">License price:</div>
                            <div class="_label">
                                @if($product->pricing['license_price']['onsubmit']=='off')
                                    ${{empty($product->pricing['license_price']['price']) ? '0.00' : $product->pricing['license_price']['price']}} / agent
                                @else
                                    <div>On submit</div>
                                    @if($product->is_web_click && $product->license_price_link)
                                        <div class="_action">
                                            <a href="{{$product->license_price_link}}" target="_blank" class="_btn btn btn-purple">Get price</a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @endif
                        @if($product->pricing['free_trial']['active']=='on')
                        <div class="_item _item--btn">
                            <div class="_title">Free trial:</div>
                            <div class="_label">
                                <div class="icon-mark">Yes</div>
                                <div class="_action">
                                    @if(isset($product->pricing['free_trial']['button']) && $product->pricing['free_trial']['button']=='on' && $product->is_web_click && $product->free_trial_link)
                                        <a href="{{$product->free_trial_link}}" target="_blank" class="_btn btn btn-border">Get trial</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="product-pricing__desc">
                        <p>
                            {!! $product->pricing_desc !!}
                        </p>
                    </div>
                </div>
                <div class="product-pricing__details">
                    <div class="details">
                        <div class="details__inner">
                            <div class="details__title">Product Details</div>
                            @if(count($product->details['deployment']))
                            <div class="details__item">
                                <span class="_title">Deployment:</span>
                                <span class="_label">
                                    @if(array_search('SaaS', $product->details['deployment'])!==false)<span><img src="{{asset('images/logos/img_14.png')}}" alt=""> SaaS</span>@endif
                                    @if(array_search('InHouse', $product->details['deployment'])!==false)<span><img src="{{asset('images/logos/img_15.png')}}" alt=""> InHouse</span>@endif
                                </span>
                            </div>
                            @endif
                            @if(count($product->details['desc_client']))
                            <div class="details__item">
                                <span class="_title">Desktop client:</span>
                                <div class="_label">
                                    @if(array_search('Windows', $product->details['desc_client'])!==false)<span><img src="{{asset('images/logos/img_16.png')}}" alt=""> Windows</span>@endif
                                    @if(array_search('Linux', $product->details['desc_client'])!==false)<span><img src="{{asset('images/logos/img_17.png')}}" alt=""> Linux</span>@endif
                                    @if(array_search('Mac', $product->details['desc_client'])!==false)<span><img src="{{asset('images/logos/img_18.png')}}" alt=""> Mac</span>@endif
                                    @if(array_search('Web-browser', $product->details['desc_client'])!==false)<span><img src="{{asset('images/logos/img_19.png')}}" alt=""> Web-browser</span>@endif
                                </div>
                            </div>
                            @endif
                            @if(count($product->details['mobile_version']))
                            <div class="details__item">
                                <span class="_title">Mobile version:</span>
                                <div class="_label">
                                    @if(array_search('Android', $product->details['mobile_version'])!==false)<span><img src="{{asset('images/logos/img_20.png')}}" alt=""> Android</span>@endif
                                    @if(array_search('IOS', $product->details['mobile_version'])!==false)<span><img src="{{asset('images/logos/img_21.png')}}" alt=""> IOS</span>@endif
                                    @if(array_search('Windows phone', $product->details['mobile_version'])!==false)<span><img src="{{asset('images/logos/img_22.png')}}" alt=""> Windows phone</span>@endif
                                    @if(array_search('Web-browser', $product->details['mobile_version'])!==false)<span><img src="{{asset('images/logos/img_19.png')}}" alt=""> Web-browser</span>@endif
                                </div>
                            </div>
                            @endif

                            <div class="details__item">
                                <span class="_title">Business size:</span>
                                <span class="_label">
                                    <span>{{implode(',', $product->details['business_size'])}}</span>
                                </span>
                            </div>

                            <div class="details__title details__title--m_b-s">Vendor Details</div>
                            <div class="details__item">
                                {!! $product->details['vendor_detalis'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(count($product->integrations_programs))
    <section class="section section--b_b">
        <div class="container">
            <div class="section__inner">
                <div class="section__title section__title">
                    <h2 class="h2">Integrations</h2>
                </div>

                <div class="section__body">
                    <div class="row">
                        @php $integs = \App\Models\Products::whereIn('id', $product->integrations_programs)->get(); @endphp
                        @foreach($integs as $int)
                        <div class="col-lg-2 col-sm-6">
                            <div class="integration-item">
                                <div class="_img"><a href="{{route('product', ['product' => $int->slug])}}" class="_link"><img src="{{asset($int->logo)}}" alt="{{$int->title}}"></a></div>
                                <div class="_title"><a href="{{route('product', ['product' => $int->slug])}}">{{$int->title}}</a></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="section section--b_b average">
        <div class="container">
            <div class="section__inner">
                <div class="section__title">
                    <h2 class="h2">Average ratings</h2>
                </div>

                <div class="section__body">
                    <div class="row">
                        <div class="col-lg-3 average__total">
                            <div class="rating">
                                <div class="rating__inner">
                                    @php

                                        $rev_rait_total = $product->review_rait_total;
                                        $rev_rait = explode('.', $rev_rait_total);
                                    @endphp
                                    <div class="rating__info">
                                        <div class="rating__label ">Overall:</div>

                                        <div class="rating__star ">
                                            <div class="rating-star ">
                                                <div class="rating-star__inner">
                                                    <div class="rating-star__empty"></div>
                                                    <div class="rating-star__fill" style="width: {{(100/5)*$rev_rait_total}}%"></div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="rating__total">
                                        <div class="rating-total__value {{$product->color}}">
                                            <span class="_label">{{$rev_rait[0]}}</span>{{isset($rev_rait[1]) ? '.'.substr($rev_rait[1], 0, 2) : ''}}/5
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-9 average__star">

                            <div class="rating-all">
                                <div class="_item">
                                    <div class="rating">
                                        <div class="rating__inner">
                                            <div class="rating__info">
                                                <div class="rating__label rating__label--big">Easy-of-use:</div>

                                                <div class="rating__star rating__star--mt">
                                                    <div class="rating-star ">
                                                        <div class="rating-star__inner">
                                                            <div class="rating-star__empty"></div>
                                                            <div class="rating-star__fill" style="width: {{$rev_count ? (100/5)*($product->easy_of_use/$rev_count) : 0}}%"></div>
                                                        </div>
                                                    </div>

                                                    <div class="rating__value">{{$rev_count ? substr($product->easy_of_use/$rev_count, 0, 3) : 0}}/5</div>

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
                                                            <div class="rating-star__fill" style="width: {{$rev_count ? (100/5)*($product->functionality/$rev_count) : 0}}%"></div>
                                                        </div>
                                                    </div>

                                                    <div class="rating__value">{{$rev_count ? substr($product->functionality/$rev_count, 0, 3):0}}/5</div>

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
                                                            <div class="rating-star__fill" style="width: {{$rev_count ? (100/5)*($product->product_quality/$rev_count):0}}%"></div>
                                                        </div>
                                                    </div>

                                                    <div class="rating__value">{{$rev_count ? substr($product->product_quality/$rev_count, 0, 3):0}}/5</div>

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
                                                            <div class="rating-star__fill" style="width: {{$rev_count ? (100/5)*($product->customer_support/$rev_count):0}}%"></div>
                                                        </div>
                                                    </div>

                                                    <div class="rating__value">{{$rev_count ? substr($product->customer_support/$rev_count, 0, 3):0}}/5</div>

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
                                                            <div class="rating-star__fill" style="width: {{$rev_count ? (100/5)*($product->value_for_money/$rev_count):0}}%"></div>
                                                        </div>
                                                    </div>

                                                    <div class="rating__value">{{$rev_count ? substr($product->value_for_money/$rev_count, 0, 3):0}}/5</div>

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
    </section>

    <section class="section section--pink">
        <div class="container">
            <div class="section__inner">
                <div class="section__title">
                    <h2 class="h2">Recomended software</h2>
                </div>

                <div class="section__body">
                    <div class="_row row">
                        @foreach(\App\Models\Products::take(4)->where('web_site', '!=', '')->orderBy('review_rait_total', 'desc')->get() as $soft)
                            @include('sections.soft.soft_item', ['soft' => $soft])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if($product->reviews->count())
    <section class="section section--gray section--shadow">
        <div class="container">
            <div class="section__inner">
                <div class="section__title">
                    <h2>Latest reviews</h2>
                    <div class="_action hidden-xs">
                        <button class="_btn btn btn-purple btn-add" data-popup="add-review"><i></i>Add review</button>
                    </div>
                </div>
                @php //dump($product->reviews); @endphp
                <div class="section__body">
                    @foreach($product->reviews->sortByDesc('id')->take(5) as $r)
                        @include('sections.soft.review_item', ['r' => $r])
                    @endforeach
                </div>

                <div class="section__action section__action--center section__action--m_w">
                    @if($product->reviews->sortByDesc('id')->count() > 5)
                    <a href="{{route('product.reviews', ['product' => $product->slug])}}" class="btn btn-border btn-radius btn-radius--big btn-big">All reviews</a>
                    @endif
                    <button class="btn btn-purple btn-big btn-add btn-radius" data-popup="add-review"><i></i>Add review</button>
                </div>
            </div>
        </div>
    </section>
    @endif
    @if($news_count = $product->news->count())
    <section class="section contact-center">
        <div class="container">
            <div class="section__inner">
                <div class="section__title">
                    <h2 class="h2">{{$product->title}} News and updates</h2>
                </div>
                @php
                    $news = collect($product->news)->sortByDesc('created_at')->take(5);

                    $sort_news = [];
                    $iteration = 0;
                    foreach ($news as $new){
                        if(!isset($sort_news[$iteration]))
                            $sort_news[$iteration][] = $new;
                        elseif (count($sort_news[$iteration]) < 3)
                            $sort_news[$iteration][] = $new;
                        else
                            $sort_news[++$iteration][] = $new;
                    }
                @endphp

                <div class="section__body">
{{--                    @foreach($sort_news as $news)--}}
                    <div class="row">
                        @php $news = $sort_news[0]; $lg = count($news)==3 ? 4 : (count($news)==2 ? 6 : 12); @endphp
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
                    {{--@endforeach--}}
                </div>
                @if($news_count>3)
                <div class="section__action section__action--center">
                    <a href="{{route('product.news', ['product' => $product->slug])}}" class="btn btn-border btn-radius btn-radius--big btn-big">All news</a>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif
@endsection
@push('scripts')
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type":  "ClaimReview",
    "datePublished": "{{$product->created_at}}",
    "url": "{{route('product', ['product' => $product->slug])}}",
    "claimReviewed": "{{$product->title}}",
    "reviewRating": {
        "@type": "Rating",
        "ratingValue": {{$product->review_rait_total}},
        "bestRating": 5,
        "alternateName": "True",
        "image": "{{asset($product->logo)}}"
    }
}
</script>
@endpush