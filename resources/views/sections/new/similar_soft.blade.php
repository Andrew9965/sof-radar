@php
    $rev_count = $item->review_count;
    $rev_rait_total = $item->review_rait_total;
@endphp

<div class="news__similar">
    <div class="news__similar-header">
        <div class="news__similar-logo"><a href="{{route('product', ['product' => $item->slug])}}"><img src="{{asset($item->logo)}}" width="24" alt=""></a></div>
        <div class="news__similar-title"><a href="{{route('product', ['product' => $item->slug])}}">{{$item->title}}</a></div>
    </div>
    <div class="news__similar-info">
        @foreach($categories->whereIn('id', $item->categories)->all() as $cat)
            <a href="{{route('category', ['categories' => $cat->slug])}}">{{$cat->title}}</a>@if(!$loop->last), @endif
        @endforeach
    </div>
    <div class="news__similar-desc">{!! mb_strimwidth($item->short_description, 0, 127, "...") !!}</div>
    <div class="news__similar-label">
        <span class="_title">Business size:</span> <span class="_label">{{implode(',', $item->details['business_size'])}}</span>
    </div>
    <div class="news__similar-rating">
        <div class="rating">
            <div class="rating__inner">
                <div class="rating__info">

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

            </div>
        </div>

    </div>
</div>