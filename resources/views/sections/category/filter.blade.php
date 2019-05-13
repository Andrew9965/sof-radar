<div class="filter js-filter-box">
    <div class="filter__box">
        @if(request()->related_links)
        <form action="{{route('relate', ['related_links' => $category->slug])}}" id="filter-form">
        @else
        <form action="{{route('category', ['category' => $category->slug])}}" id="filter-form">
        @endif
            <div class="filter__inner js-custom-scroll">
                @if($category->filter && count(array_diff($category->filter, [0])))
                    <div class="filter__header">
                        <div class="_title">Filters</div>
                        @if(count(request()->all()))
                            @if(request()->related_links)
                                <div class="_action"><button onclick="$(this).parents('form').find('[checked]').removeAttr('checked'); location='{{route('relate', ['related_links' => $category->slug])}}';" class="_btn" type="reset"><i></i>Clear</button></div>
                            @else
                                <div class="_action"><button onclick="$(this).parents('form').find('[checked]').removeAttr('checked'); location='{{route('category', ['category' => $category->slug])}}';" class="_btn" type="reset"><i></i>Clear</button></div>
                            @endif
                        @endif
                    </div>
                    <div class="filter__body">

                        @foreach(array_diff($category->filter, [0]) as $shape => $filter)
                            @if($filter)
                                @include('blocks.filter.'.$shape, ['category' => $category])
                                @if(!$loop->last)
                                    <hr>
                                @endif
                            @endif
                        @endforeach

                        <div class="filter__action">
                            <button class="btn btn-apply btn-purple btn-small w100" type="submit"><i></i>Apply</button>
                        </div>
                    </div>
                @endif
                @if(!request()->related_links)
                        @php
                            $similars = \Help\ArrayClass::convert($category->similar, 'category_id', 'category_id')->toArray();
                            $parents = \Help\ArrayClass::convert($category->iParents, 'parent_id', 'parent_id')->toArray();
                            $similars = $categories->whereIn('id', $similars);
                            //dump($similars);
                        @endphp
                        @if($similars->count())
                            <div class="sidebar-link">
                                <div class="_title">Similar Categories</div>
                                @foreach($similars as $similar)
                                    <div class="_item"><a href="{{route('category', ['category' => $similar->slug])}}">{{$similar->title}}</a></div>
                                @endforeach
                            </div>
                        @endif
                @endif
            </div>
            @if($category->filter && count(array_diff($category->filter, [0])) && count(request()->all()))
                @if(request()->related_links)
                    <div class="filter__clear"><button onclick="$(this).parents('form').find('[checked]').removeAttr('checked'); location='{{route('relate', ['related_links' => $category->slug])}}';" class="_btn js-filter-reset active" type="reset"><i></i>Clear</button></div>
                @else
                    <div class="filter__clear"><button onclick="$(this).parents('form').find('[checked]').removeAttr('checked'); location='{{route('category', ['category' => $category->slug])}}';" class="_btn js-filter-reset active" type="reset"><i></i>Clear</button></div>
                @endif
            @endif
        </form>
    </div>
</div>