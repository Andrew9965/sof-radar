@php
    $model = \App\Models\ProductNews::orderBy('created_at', 'desc')->whereHas('product')->take(4)->get();
@endphp
@if($model->count())
<section class="section section--gray-light">
    <div class="container">
        <div class="section__inner">
            <div class="section__title">
                <h2 class="h2">{{isset($category->title) ? $category->title.' ' : ''}} News and updates</h2>
            </div>
            <div class="section__body">
                <div class="_row row">
                    @foreach($model as $new)
                        @if($new->product)
                            <div class="col-lg-3 col-md-6">
                                @include('sections.new.new_item', ['new' => $new])
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="section__action section__action--center">
                <a href="{{route('product.news.all')}}" class="btn btn-border btn-radius btn-radius--big btn-big">All news</a>
            </div>
        </div>
    </div>
</section>
@endif