@php
    if(!isset($prods)) $prods = $product_categories->where('category_id', $category->id)->pluck('product')->pluck('id');
    $news = \App\Models\ProductNews::orderBy('created_at', 'desc')->whereIn('product_id', $prods)->take(4)->get();
@endphp
@if($news->count())
<section class="section section--gray-light">
    <div class="container">
        <div class="section__inner">
            <div class="section__title">
                <h2 class="h2">{{isset($category->title) ? $category->title.' ' : ''}} News and updates</h2>
            </div>
            <div class="section__body">
                <div class="_row row">

                    @foreach($news as $new)
                    <div class="col-lg-3 col-md-6">
                        @include('sections.new.new_item', ['new' => $new])
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="section__action section__action--center">
                @if(request()->related_links)
                    <a href="{{route('product.news.all')}}" class="btn btn-border btn-radius btn-radius--big btn-big">All news</a>
                @else
                    <a href="{{route('category.news', ['categories' => $category->slug])}}" class="btn btn-border btn-radius btn-radius--big btn-big">All news</a>
                @endif
            </div>
        </div>
    </div>
</section>
@endif