<form action="{{route('product.reviews.post', ['product' => $product->slug])}}" method="post" class="submit_review">
    {{csrf_field()}}
    @if($edit)
        <input type="hidden" name="review_edit" value="{{$edit->id}}" />
    @endif
    <a href="#" class="popup-close js-close-wnd"></a>
    <div class="popup__title">

        <span id="popup_title_0" class="popup_titles_my" style="display: none">
            <div class="_text">Excellent!</div>
            <div class="_title">Would you like to add review about {{$product->title}}? </div>
            <div class="_label">Log in with Facebook or Google account, and do it now!</div>
            <br>
            <div class="_label"><sup>*</sup> required fields</div>
        </span>

        <span id="popup_title_1" class="popup_titles_my">
            <div class="_text">{{$edit ? 'Edit' : 'Add'}} your review about</div>
            <div class="_title">{{$product->title}}</div>
            <div class="_label"><sup>*</sup> required fields</div>
        </span>

    </div>
    <div class="popup__rating">
        <div class="popup__rating-title">
            <span> Rate this software from</span>
            <i class="fill"></i>
            <span>(bad) to</span>
            <i class="fill"></i>
            <i class="fill"></i>
            <i class="fill"></i>
            <i class="fill"></i>
            <i class="fill"></i>
            <span>great</span>
        </div>
        <div class="popup__rating-inner">
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
                                            <div class="rating-star__fill" style="width: {{$edit ? $edit->easy_of_use*20 : 0}}%"></div>
                                        </div>
                                    </div>

                                    <div class="rating__value">{{$edit ? $edit->easy_of_use : 0}}/5</div>
                                    <input class="rate" name="easy_of_use" type="hidden" value="{{$edit ? $edit->easy_of_use : 0}}" />
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
                                            <div class="rating-star__fill" style="width: {{$edit ? $edit->functionality*20 : 0}}%"></div>
                                        </div>
                                    </div>

                                    <div class="rating__value">{{$edit ? $edit->functionality : 0}}/5</div>
                                    <input class="rate" name="functionality" type="hidden" value="{{$edit ? $edit->functionality : 0}}" />

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
                                            <div class="rating-star__fill" style="width: {{$edit ? $edit->product_quality*20 : 0}}%"></div>
                                        </div>
                                    </div>

                                    <div class="rating__value">{{$edit ? $edit->product_quality : 0}}/5</div>
                                    <input class="rate" name="product_quality" type="hidden" value="{{$edit ? $edit->product_quality : 0}}" />

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
                                            <div class="rating-star__fill" style="width: {{$edit ? $edit->customer_support*20 : 0}}%"></div>
                                        </div>
                                    </div>

                                    <div class="rating__value">{{$edit ? $edit->customer_support : 0}}/5</div>
                                    <input class="rate" name="customer_support" type="hidden" value="{{$edit ? $edit->customer_support : 0}}" />

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
                                            <div class="rating-star__fill" style="width: {{$edit ? $edit->value_for_money*20 : 0}}%"></div>
                                        </div>
                                    </div>

                                    <div class="rating__value">{{$edit ? $edit->value_for_money : 0}}/5</div>
                                    <input class="rate" name="value_for_money" type="hidden" value="{{$edit ? $edit->value_for_money : 0}}" />

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="popup__form">
        <div class="popup__form-title">
            <div class="_title">Your review</div>
        </div>
        <div class="popup__form-row">
            <label class="popup__form-label required"><span class="_big" style="color: #7440b3">Headline:</span></label>
            <input type="text" name="headline" value="{{$edit ? $edit->headline : ''}}" class="popup__form-input popup__form-input--big counter" placeholder="Describe your experience in a few words">
            <div class="popup__form-symbol"><span>0</span>/200</div>
        </div>

        <div class="popup__form-row">
            <label class="popup__form-label required"><span style="color: #7440b3">Like best:</span></label>
            <textarea class="popup__form-area counter" name="like_best" placeholder="What do you like most about this software. 100 - 1500 character.">{{$edit ? $edit->like_best : ''}}</textarea>
            <div class="popup__form-symbol"><span>0</span>/1500</div>
        </div>

        <div class="popup__form-row">
            <label class="popup__form-label required"><span style="color: #7440b3">Like least:</span></label>
            <textarea class="popup__form-area counter" name="like_least" placeholder="What do you like most about this software. 100 - 1500 character.">{{$edit ? $edit->like_least : ''}}</textarea>
            <div class="popup__form-symbol"><span>0</span>/1500</div>
        </div>

        <div class="popup__form-row">
            <label class="popup__form-label required"><span style="color: #7440b3">Comment:</span></label>
            <textarea class="popup__form-area counter" name="comment" placeholder="Summarize about your experience in using this software">{{$edit ? $edit->comment : ''}}</textarea>
            <div class="popup__form-symbol"><span>0</span>/1500</div>
        </div>

        <div class="popup__form-row">
            <label class="popup__form-label required"><span class="_small" style="color: #434262">How long do you use this software</span></label>
            <div class="popup__form-select w245">
                <select name="used">
                    <option {{$edit && $edit->used == 'Less than 6 month' ? 'selected' : ''}}>Less than 6 month</option>
                    <option {{$edit && $edit->used == 'Less than 12 month' ? 'selected' : ''}}>Less than 12 month</option>
                    <option {{$edit && $edit->used == 'Less than 18 month' ? 'selected' : ''}}>Less than 18 month</option>
                    <option {{$edit && $edit->used == 'Less than 24 month' ? 'selected' : ''}}>Less than 24 month</option>
                    <option {{$edit && $edit->used == 'Less than 30 month' ? 'selected' : ''}}>Less than 30 month</option>
                </select>
            </div>
        </div>
    </div>
    <div class="popup__form">
        <div class="popup__container--small">
            <div class="popup__form-action w245">
                <button class="btn btn-purple w100 btn-big" type="submit">Submit Review</button>
            </div>
        </div>
    </div>
</form>