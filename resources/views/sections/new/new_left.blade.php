@php
    $rev_count = $product->review_count;
    $rev_rait_total = $product->review_rait_total;
    $rev_rait = explode('.', $rev_rait_total);
@endphp
<div class="col-lg-3">
    <div class="news__sidebar">
        <div class="news__item">
            <div class="news__item-img"><a href="{{route('product', ['product' => $product->slug])}}"><img src="{{asset($product->logo)}}" alt="{{$product->title}}"></a></div>
            <div class="news__item-title"><a href="{{route('product', ['product' => $product->slug])}}">{{$product->title}}</a></div>
            <div class="news__item-rating">
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
            <div class="news__item-desc">
                @foreach($categories->whereIn('id', $product->categories)->all() as $cat)
                    <span><a href="{{route('category', ['categories' => $cat->slug])}}">{{$cat->title}}</a></span>
                @endforeach
            </div>
            <div class="news__item-label">
                <span class="_title">Business size:</span> <span class="_label">{{implode(',', $product->details['business_size'])}}</span>
            </div>
            <div class="news__item-info">{!! $product->short_description !!}</div>
            <div class="news__item-action">
                @if($product->is_click)
                    <a href="{{route('product.link', ['product' => $product->slug])}}" target="_blank" class="_btn btn-small btn btn-border w100">Visit website</a>
                @else
                    <a href="{{route('product', ['product' => $product->slug])}}" class="_btn btn-small btn btn-purple">Read more</a>
                @endif
            </div>
        </div>
        <hr>

        <div class="news__item">
            <div class="news__item-title">Similar products</div>
            @php
                $products = \App\Models\Products::where('id', '!=', $product->id)->where(function($query) use ($product){
                    $query->orWhere('category_1', $product->category_1);
                    $query->orWhere('category_2', $product->category_1);
                    $query->orWhere('category_3', $product->category_1);
                })->orderBy('review_rait_total', 'desc')->take(4)->get();

                $p1 = $products->where('web_site', '!=', '')->all();
                $p2 = $products->where('web_site', '==', '')->all();

                $prodSem = (new Illuminate\Database\Eloquent\Collection)->merge($p1)->merge($p2);
            @endphp
            @foreach($prodSem as $sProd)
                @include('sections.new.similar_soft', ['item' => $sProd])
            @endforeach

            <div class="news__item-action">
                <a href="{{route('product.alternative', ['product' => $product->slug])}}" class="btn btn-border">All similar products</a>
            </div>
        </div>

    </div>
</div>