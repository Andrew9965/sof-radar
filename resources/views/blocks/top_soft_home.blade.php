<section class="section section--gray">
    <div class="container">
        <div class="section__inner">
            <div class="section__title">
                <h2 class="h2">Top-rated software solutions</h2>
            </div>
            <div class="section__body">
                <div class="_row row">

                    @foreach($top_soft as $soft)
                    <div class="col-lg-3 col-md-6">
                        <div class="top-software__item ">
                            <div class="top-software__inner">
                                <div class="top-software__body">
                                    <div class="top-software__logo"><a href="#" class="_link"><img src="{{asset($soft->logo)}}" alt=""></a></div>
                                    <div class="top-software__title"><a href="#" class="_link">{{$soft->title}}</a></div>
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
                                                              <div class="rating-star__fill" style="width: 50%"></div>
                                                      </div>
                                                  </div>

                                                    <div class="rating__value">3/5</div>

                                                    <div class="rating__comment">
                                                      <div class="icon-comment">
                                                        <i></i><a href="#">112</a>
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
                                            <a href="{{route('product.link', ['product' => $soft->slug])}}" class="_btn btn-small btn btn-border w100">Visit website</a>
                                        @else
                                            <a class="_btn btn-small btn btn-purple">Read more</a>
                                        @endif
                                    </div>
                                </div>

                                <div class="top-software__footer">
                                    <a href="#">{{$categories->where('id', $soft->categories[1])->first()->title}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="section__action section__action--center">
                <button class="btn btn-border btn-radius btn-radius--big btn-big">All top-rated software</button>
            </div>
        </div>
    </div>
</section>