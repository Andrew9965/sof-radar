@php
    $rev_count = $item->review_count;
    $rev_rait_total = $item->review_rait_total;
    $rev_rait = explode('.', $rev_rait_total);
    $route = Route::currentRouteName();
@endphp
<div class="review-item review-item--m_b">
    <div class="review-item__inner">
        <div class="review-item__header">

            <div class="review-item__header-company">
                <div class="_logo"><a {{$item->is_click ? 'target="_blank"':''}} href="{{route($item->is_click ? 'product.link' : 'product', ['product' => $item->slug])}}"><img src="{{asset($item->logo)}}" alt="{{$item->title}}" width="53"></a></div>
                <div class="_info">
                    <div class="_title"><a {{$item->is_click ? 'target="_blank"':''}} href="{{route($item->is_click ? 'product.link' : 'product', ['product' => $item->slug])}}">{{$item->title}}</a></div>
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
                                        <div class="rating-star__fill" style="width: {{(100/5)*$rev_rait_total}}%"></div>
                                    </div>
                                </div>


                                <div class="rating__comment">
                                    <div class="icon-comment">
                                        <i></i><a href="{{route('product.reviews', ['product' => $item->slug])}}">{{$rev_count}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rating__total">
                            <div class="rating-total__value {{$item->color}} ">
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
                    @foreach($categories->whereIn('id', $item->categories)->all() as $cat)
                        <a href="{{route('category', ['categories' => $cat->slug])}}">{{$cat->title}}</a>
                        @if(!$loop->last) | @endif
                    @endforeach
                </div>
                    <div class="_size">Business size: <span>{{implode(',', $item->details['business_size'])}}</span></div>
            </div>
            <div class="_action">
                <div class="input-slider">
                    <input
                            type="checkbox"
                            {{$used->where('product_id',$item->id)->count() ? 'checked' : ''}}
                            class="_input" data-prod-title="{{$item->title}}"
                            data-uses="{{$item->slug}}"
                            data-prod-id="{{$item->id}}"
                            data-cat-slug="{{request()->categories ? request()->categories->slug : $item->category1->slug}}"
                            id="input-uses-{{$item->id}}">
                    <label for="input-uses-{{$item->id}}" class="_label">i already use</label>
                </div>
            </div>
        </div>




        <div class="review-item__body">

            <div class="_inner">
                <div class="_item">
                    <div class="_desc">{!! $item->short_description !!}</div>
                    <div class="_link"><a href="{{route('product', ['product' => $item->slug])}}">Learn more about {{$item->title}}</a></div>
                </div>
            </div>

            <div class="_action">
                @if($item->is_click)
                    <a href="{{route('product.link', ['product' => $item->slug])}}" target="_blank" class="_btn btn btn-purple ">Visit Website</a>
                @endif
                @if(!request()->related_links && $route=='category')
                <a href="{{route('product.compare_item', ['product' => $item->slug])}}" class="_btn btn btn-border">Add to compare</a>
                @endif
            </div>

            @if($loop->iteration % 2 ==0)
            <div class="_banner">
                {!! banner('category') !!}
            </div>
            @endif
        </div>


    </div>
</div>