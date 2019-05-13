@extends($product->id ? 'layouts.soft' : 'layouts.app')

@section($product->id ? 'soft-content' : 'content')
        <div class="page-default__inner">
            @if(!$product->id)
            <div class="breadcrumbs ">
                <div class="container">
                    <div class="breadcrumbs-inner">
                        <a href="{{route('product.news.all')}}">News and updates</a>
                    </div>
                    @if(isset($category))
                        <div class="breadcrumbs-inner">
                            <a href="{{route('category', ['categories' => $category->slug])}}">{{$category->title}}</a>
                        </div>
                    @endif
                </div>
            </div>
            @endif



            <div class="news {{$product->id ? 'section section--shadow review-info' : ''}}">
                <div class="container section__body">
                    <div class="_row row">
                        @foreach($news as $new)
                            <div class="col-lg-3">
                                @include('sections.new.new_item', ['new' => $new])
                            </div>
                            @if($loop->iteration % 4 == 0)
                                </div>
                                <div class="_row row  hidden-sm  hidden-xs">
                            @endif
                        @endforeach
                    </div>

                    {{$news->links()}}
                </div>

            </div>


            <section class="section section--pink">
                <div class="container">
                    <div class="section__inner">
                        <div class="section__title">
                            <h2 class="h2">Recomended software</h2>
                        </div>

                        <div class="section__body">
                            <div class="_row row">
                                @foreach(\App\Models\Products::take(4)->orderBy('review_rait_total', 'desc')->get() as $soft)
                                    @include('sections.soft.soft_item', ['soft' => $soft])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection