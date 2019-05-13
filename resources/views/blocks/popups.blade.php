@php
    //$edit = \App\Models\Reviews::where('id', request()->review_edit)->where('user_id', (isset(Auth::user()->id) ? Auth::user()->id : 0) )->first();
    $edit1 = session('edit');
    if($edit1) $edit = (object)$edit1;
    else $edit = null;
@endphp


<div class="popup" id="add-review">
    <div class="popup-inner">
{{--        {{dump($edit)}}--}}
        @auth
            @if(isset($product->id))

                @if(Auth::user()->reviews->where('product_id', $product->id)->count() && !$edit)
                    @php
                        $my = Auth::user()->reviews->where('product_id', $product->id)->first();
                    @endphp
                    <a href="#" class="popup-close js-close-wnd"></a>
                    <div class="popup__title">
                        <div class="_title">Sorry!</div>
                        <div class="_title">You have already left a review for this product!</div>
                        <div class="popup__form">
                            <div class="popup__container--small">
                                <div class="popup__form-action w245">
                                    <a href="{{route('product.review', ['product' => $my->product->slug, 'review' => $my->id])}}" class="btn btn-small btn-border" type="submit">look it here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else


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

                    @include('blocks.review_form', ['edit' => $edit])

                    <div class="popup__form">
                        <div class="popup__container--small">
                            <div class="popup__form-action w245">
                                <button class="btn btn-purple w100 btn-big" type="submit">Submit Review</button>
                            </div>
                        </div>
                    </div>
                </form>
                @endif
            @else
            <form action="{{route('product.reviews.post.und')}}" method="post" class="submit_review">
                {{csrf_field()}}
                <a href="#" class="popup-close js-close-wnd"></a>
                <div class="popup__title">
                    <div class="_title">Add your review</div>
                    <div class="popup__select" style="max-width: none;">
                        <div class="popup__select-title">Select a product</div>
                        <div class="popup__select-product">
                            <select name="product_id" id="select" class="js-select-product counter_required" data-placeholder="Select a product"></select>
                        </div>
                        <div class="popup__select-two">
                            <span id="cat_product_title"></span>
                        </div>
                    </div>

                    <div class="_label"><sup>*</sup> required fields</div>
                </div>

                @include('blocks.review_form', ['edit' => $edit])

                <div class="popup__form">
                    <div class="popup__container--small">
                        <div class="popup__form-action w245">
                            <button class="btn btn-purple w100 btn-big" type="submit">Submit Review</button>
                        </div>
                    </div>
                </div>

            </form>
            @endif
        @else

        @include('blocks.auth_body')

        @endauth
    </div>
</div>

@if($edit)
    @push('scripts')
    <script>
        $(function(){
            Popups.openById('add-review');
        });
    </script>
    @endpush
@endif