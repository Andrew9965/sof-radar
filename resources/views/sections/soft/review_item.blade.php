@if($r->product)
@php
    $r_rait_total = ($r->easy_of_use+$r->functionality+$r->product_quality+$r->customer_support+$r->value_for_money)/5;
    $r_rait = explode('.', $r_rait_total);
@endphp
<div class="review-item review-item--m_b">
    <div class="review-item__inner">
        <div class="review-item__header {{isset($fool) && $fool ? 'company-block-home':''}}">
            @if(isset($fool) && $fool)
            <div class="review-item__header-company">
                <div class="_logo"><a href="{{route('product', ['product' => $r->product->slug])}}"><img src="{{asset($r->product->logo)}}" alt="" width="53"></a></div>
                <div class="_info">
                    <div class="_title"><a href="{{route('product', ['product' => $r->product->slug])}}">{{$r->product->title}}</a></div>
                    @if($categories->where('id', $r->product->categories[1])->first()!=null)
                    <div class="_action">
                        <a href="{{route('category', ['categories' => $categories->where('id', $r->product->categories[1])->first()->slug])}}">{{$categories->where('id', $r->product->categories[1])->first()->title}}</a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            @if(!empty($r->headline)) <div class="review-item__header-quote hidden-xs"><a href="{{route('product.review', ['product' => $r->product->slug,'review' => $r->id])}}">«{{$r->headline}}»</a></div> @endif
            <div class="review-item__header-rating">
                <div class="rating">
                    <div class="rating__inner">
                        <div class="rating__info">
                            <div class="rating__label ">Average rating:</div>

                            <div class="rating__star ">
                                <div class="rating-star ">
                                    <div class="rating-star__inner">
                                        <div class="rating-star__empty"></div>
                                        <div class="rating-star__fill" style="width: {{(100/5)*$r_rait_total}}%"></div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="rating__total">
                            <div class="rating-total__value {{$r->color}} ">
                                <span class="_label">{{$r_rait[0]}}</span>{{isset($r_rait[1]) ? '.'.substr($r_rait[1], 0, 2) : ''}}/5
                            </div>
                        </div>
                    </div>
                </div>


                <div class="_action hidden-md hidden-sm"><a class="_btn js-review-rating-open">Details</a></div>

            </div>
        </div>

        <div class="review-item__main  review-item__main--details">
            <div class="review-item__main-info">
                <div class="_item">
                    <div class="_label">Review by:</div>
                    <div class="_title">{{$r->user->name}}</div>
                    <div class="_desc">{{$r->user->position}}</div>
                </div>
                <div class="_item">
                    <div class="_label">Used software for:</div>
                    <div class="_title">{{$r->used}}</div>
                </div>
            </div>

            <div class="review-item__main-rating">

                <div class="rating-all">
                    <div class="_item">
                        <div class="rating">
                            <div class="rating__inner">
                                <div class="rating__info">
                                    <div class="rating__label ">Easy-of-use:</div>

                                    <div class="rating__star rating__star--mt">
                                        <div class="rating-star rating-star--small">
                                            <div class="rating-star__inner">
                                                <div class="rating-star__empty"></div>
                                                <div class="rating-star__fill" style="width: {{(100/5)*$r->easy_of_use}}%"></div>
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
                                                <div class="rating-star__fill" style="width: {{(100/5)*$r->functionality}}%"></div>
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
                                                <div class="rating-star__fill" style="width: {{(100/5)*$r->product_quality}}%"></div>
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
                                                <div class="rating-star__fill" style="width: {{(100/5)*$r->customer_support}}%"></div>
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
                                                <div class="rating-star__fill" style="width: {{(100/5)*$r->value_for_money}}%"></div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="review-item__main-action">
                <button class="_btn js-review-rating-close">Close</button>
            </div>
        </div>

        <div class="review-item__body">

            <div class="_inner">
                <div class="review-item__header-quote hidden-md hidden-sm"><a href="#">«{{$r->headline}}»</a></div>
                <div class="_item">
                    <div class="_label text-green">Like best:</div>
                    <div class="_desc">{{$r->like_best}}</div>
                </div>

                <div class="_item">
                    <div class="_label text-red">Like least:</div>
                    <div class="_desc">{{$r->like_least}}</div>
                </div>

                <div class="_item">
                    <div class="_label">Comments:</div>
                    <div class="_desc">{{$r->comment}}</div>
                </div>
            </div>

            <div class="_action">
                @if(isset($fool) && $fool)
                <a href="{{route('product.reviews', ['product' => $r->product->slug])}}" class="_btn btn btn-purple btn-big-w">View {{$r->product->reviews->count()}} reviews</a>
                @endif
                @auth
                    @if($r->user_id == Auth::user()->id)
                        <form style="display: none" action="{{route('product.reviews.post.edit', ['review' => $r->id])}}" data-edit="{{$r->id}}" method="post">
                            {{csrf_field()}}
                        </form>
                        <a onclick="$('[data-edit={{$r->id}}]').submit(); return false;" class="_btn btn btn-purple btn-big-w">Edit</a>
                    @endif
                @endauth
            </div>
        </div>

        <div class="review-item__footer">
            <div class="_time">
                {{Date\DateFormat::post($r->created_at)}}
            </div>
            <div class="review-item__footer-action">
                <div class="_label">Helpful?</div>
                <div class="like">
                    <div class="like__inner" {{!isset($_COOKIE['likes']) || !isset(json_decode($_COOKIE['likes'], true)[$r->id]) ? 'data-like='.$r->id:'data-like'}}>
                        <div class="like__up">
                            {{$r->like}} <button class="_btn"><i></i></button>
                        </div>
                        <div class="like__down">
                            {{$r->dislike}} <button class="_btn"><i></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endif