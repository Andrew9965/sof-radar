@php
    $rev_count = $soft->review_count;
    $rev_rait_total = $soft->review_rait_total;
@endphp

<div class="col-lg-3 col-md-6">
    <div class="top-software__item ">
        <div class="top-software__inner">
            <div class="top-software__body">
                <div class="top-software__logo"><a {{$soft->is_click ? 'target="_blank"':''}} href="{{route($soft->is_click ? 'product.link' : 'product', ['product' => $soft->slug])}}" class="_link"><img src="{{asset($soft->logo)}}" alt=""></a></div>
                <div class="top-software__title"><a href="{{route('product', ['product' => $soft->slug])}}" class="_link">{{$soft->title}}</a></div>
                <div class="top-software__rating">
                    <span class="_title">Rating</span>
                    <span class="_label">
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

                                <div class="rating__value">{{substr($rev_rait_total, 0, 3)}}/5</div>

                                <div class="rating__comment">
                                  <div class="icon-comment">
                                    <i></i><a {{$soft->is_click ? 'target="_blank"':''}} href="{{route($soft->is_click ? 'product.link' : 'product.reviews', ['product' => $soft->slug])}}">{{$rev_count}}</a>
                                  </div>
                                </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </span>
                </div>
                <div class="top-software__info">
                    <span class="_title">Business size:</span> <span class="_label">{{implode(',', $soft->details['business_size'])}}</span>
                </div>
                <div class="top-software__desc">{!! $soft->short_description !!}</div>
                <div class="top-software__action">
                    @if($soft->is_click)
                        <a href="{{route('product.link', ['product' => $soft->slug])}}" target="_blank" class="_btn btn-small btn btn-border w100">Visit website</a>
                    @else
                        <a href="{{route('product', ['product' => $soft->slug])}}" class="_btn btn-small btn btn-purple">Read more</a>
                    @endif
                </div>
            </div>

            <div class="top-software__footer">
                @if($categories->where('id', $soft->categories[1])->first())
                <a href="{{route('category', ['categories' => $categories->where('id', $soft->categories[1])->first()->slug])}}">
                    {{$categories->where('id', $soft->categories[1])->first()->title}}
                    {{--{{dd($categories->where('id', $soft->categories[1])->first()->slug)}}--}}
                </a>
                @endif
            </div>
        </div>
    </div>
</div>