@if($new->product)
@php
    $rev_count = $new->product->review_count;
    $rev_rait_total = $new->product->review_rait_total;
@endphp
<div class="news-software">
    <div class="news-software__inner">
        <div class="news-software__header">
            <div class="_time">{{Date\DateFormat::post($new->created_at)}}</div>
        </div>
        <div class="news-software__body">
            <a href="{{route('product.new', ['product' => $new->product->slug,'product_new' => $new->id])}}">
                <div class="_title">{{$new->title}}</div>
                <div class="_desc">{{$new->text}}</div>
            </a>
        </div>
        @if(!isset($product->id))
        <div class="news-software__footer">
            <div class="news-software__company">
                <a href="{{route('product', ['product' => $new->product->slug])}}" class="_link">
                    <div class="_logo"><img src="{{asset($new->product->logo)}}" width="21" alt=""></div>
                    <div class="_title">{{$new->product->title}}</div>
                </a>
            </div>

            <div class="news-software__label">
                <span class="_title">Rating</span>
                <span class="_label">
                          <div class="rating">
                            <div class="rating__inner">
                              <div class="rating__info">

                                <div class="rating__star ">
                                  <div class="rating-star article-label--no_m">
                                      <div class="rating-star__inner">
                                        <div class="rating-star__empty"></div>
                                              <div class="rating-star__fill" style="width: {{(100/5)*$rev_rait_total}}%"></div>
                                      </div>
                                  </div>

                                    <div class="rating__value">{{substr($rev_rait_total, 0, 3)}}/5</div>

                                    <div class="rating__comment">
                                      <div class="icon-comment">
                                        <i></i><a href="{{route('product.reviews', ['product' => $new->product->slug])}}">{{$new->product->reviews->count()}}</a>
                                      </div>
                                    </div>
                                </div>
                              </div>

                            </div>
                          </div>

                        </span>
            </div>

        </div>
        @endif
    </div>
    @if($categories->where('id', $new->product->categories[1])->first()!=null)
{{--    {{dd($categories->where('id', $new->product->categories[1])->first())}}--}}
    <div class="news-software__action">
        <a href="{{route('category', ['categories' => $categories->where('id', $new->product->categories[1])->first()->slug])}}">{{$categories->where('id', $new->product->categories[1])->first()->title}}</a>
    </div>
    @endif
</div>
@endif