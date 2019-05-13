@extends('layouts.soft')

@section('soft-content')
    <section class="section section--shadow">
        <div class="container">
            <div class="section__inner">
                <div class="section__title">
                    <h1>{{$product->title}} Alternatives</h1>
                </div>

                <div class="block-open__filter">
                    <button class="_btn js-open-filter btn btn-big btn-purple" onclick="if($(this).hasClass('btn-apply')){$('#filter-form').submit(); return false;}"><i></i><span class="_apply" onclick="$('#filter-form').submit()">Apply</span><span class="_open">Open filter</span><span class="_close">Close</span></button>
                </div>

                <div class="section__body">
                    <div class="relative">
                        <div class="row">
                            @if($products->count())
                            <aside class="col-lg-3 aside">

                                @php
                                    $category = $product->category1;
                                @endphp

                                <div class="filter js-filter-box alternative-filter">
                                    <div class="filter__box">
                                        <form action="{{route('product.alternative', ['product' => $product->slug])}}" id="filter-form">
                                            <div class="filter__inner js-custom-scroll">
                                                @if($category->filter && count(array_diff($category->filter, [0])))
                                                    <div class="filter__header">
                                                        <div class="_title">Filters</div>
                                                        @if(count(request()->all()))
                                                            <div class="_action"><button onclick="$(this).parents('form').find('[checked]').removeAttr('checked'); location='{{route('product.alternative', ['product' => $product->slug])}}';" class="_btn" type="reset"><i></i>Clear</button></div>
                                                        @endif
                                                    </div>
                                                    <div class="filter__body">

                                                        @foreach(array_diff($category->filter, [0]) as $shape => $filter)
                                                            @if($filter)
                                                                @include('blocks.filter.'.$shape, ['category' => $category])
                                                                @if(!$loop->last)
                                                                    <hr>
                                                                @endif
                                                            @endif
                                                        @endforeach

                                                        <div class="filter__action">
                                                            <button class="btn btn-apply btn-purple btn-small w100" type="submit"><i></i>Apply</button>
                                                        </div>
                                                    </div>
                                                @endif
                                                @php
                                                    $similars = \Help\ArrayClass::convert($category->similar, 'category_id', 'category_id')->toArray();
                                                    $parents = \Help\ArrayClass::convert($category->iParents, 'parent_id', 'parent_id')->toArray();
                                                    $similars = $categories->whereIn('id', $similars+$parents);
                                                @endphp
                                                @if($similars->count())
                                                    <div class="sidebar-link">
                                                        <div class="_title">Similar Categories</div>
                                                        @foreach($similars as $similar)
                                                            <div class="_item"><a href="{{route('category', ['category' => $similar->slug])}}">{{$similar->title}}</a></div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            @if($category->filter && count(array_diff($category->filter, [0])) && count(request()->all()))
                                                <div class="filter__clear"><button onclick="$(this).parents('form').find('[checked]').removeAttr('checked'); location='{{route('product.alternative', ['product' => $product->slug])}}';" class="_btn js-filter-reset active" type="reset"><i></i>Clear</button></div>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </aside>
                            @endif
                            <div class="col-lg-9 col-md-12">
                                @foreach($products as $prod)
                                    <div class="review-item review-item--m_b review-item--compare">
                                        <div class="review-item__inner">
                                            <div class="review-item__header">

                                                <div class="review-item__header-company">
                                                    <div class="_logo"><a href="{{route('product', ['product' => $prod->slug])}}"><img src="{{asset($prod->logo)}}" width="53" alt="{{$prod->title}}"></a></div>
                                                    <div class="_info">
                                                        <div class="_title"><a href="{{route('product', ['product' => $prod->slug])}}">{{$prod->title}}</a></div>
                                                    </div>
                                                </div>

                                                <div class="review-item__header-rating">
                                                    <div class="rating">
                                                        <div class="rating__inner">
                                                            <div class="rating__info">
                                                                <div class="rating__label ">Average rating:</div>

                                                                <div class="rating__star ">
                                                                    <div class="rating-star ">
                                                                        <div class="rating-star__inner">
                                                                            <div class="rating-star__empty"></div>
                                                                            <div class="rating-star__fill" style="width: {{(100/5)*$prod->review_rait_total}}%"></div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="rating__comment">
                                                                        <div class="icon-comment">
                                                                            <i></i><a href="{{route('product.reviews', ['product' => $prod->slug])}}">{{$prod->review_count}}</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $rev_rait = explode('.', $prod->review_rait_total);
                                                            @endphp
                                                            <div class="rating__total">
                                                                <div class="rating-total__value {{$prod->color}} ">
                                                                    <span class="_label">{{$rev_rait[0]}}</span>{{isset($rev_rait[1]) ? '.'.substr($rev_rait[1], 0, 2) : ''}}/5
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="review-item__info">
                                                <div class="_info">
                                                    <div class="_title">
                                                        @foreach($categories->whereIn('id', $prod->categories)->all() as $cat)
                                                            <a href="{{route('category', ['categories' => $cat->slug])}}">{{$cat->title}}</a>
                                                            @if(!$loop->last) | @endif
                                                        @endforeach
                                                    </div>
                                                    <div class="_size">Business size: <span>{{implode(',', $prod->details['business_size'])}}</span></div>
                                                </div>
                                                <div class="_action">
                                                    @if($prod->is_click)
                                                        <a href="{{route('product.link', ['product' => $prod->id])}}" target="_blank"  class="_btn btn btn-border">Visit Website</a>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="review-item__body">
                                                <div class="_inner">
                                                    <div class="_item">
                                                        <div class="_desc">{!! $prod->short_description !!}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                {{$products->links()}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection