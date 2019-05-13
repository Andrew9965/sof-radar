<section class="section section--shadow">
    <div class="container">
        <div class="section__inner">
            <div class="section__title">
                <h2 class="h2">Top Categories</h2>
            </div>
            <div class="section__body">

                @foreach($top_categories as $cats)
                    <div class="row _row">
                        @php $lg = count($cats)==4 ? 3 : (count($cats)==3 ? 4 : (count($cats)==2 ? 6 : 12)); @endphp
                        @foreach($cats as $category)
                            <div class="col-lg-{{$lg}} {{$lg==3 ? 'col-md-6':''}}">
                                <div class="top-categories__item " style="background-image: url('{{$category['img']}}')">
                                    <a href="{{route('category', ['categories' => $category['slug']])}}" class="top-categories__inner">
                                        <span class="_hover">View category</span>
                                        <div class="_title">{{$category['title']}}</div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach

            </div>

            <div class="section__action section__action--center">
                <a href="{{route('categories')}}" class="btn btn-border btn-radius btn-radius--big btn-big">All categories</a>
            </div>
        </div>
    </div>
</section>