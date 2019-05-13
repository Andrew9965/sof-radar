<section class="section">
    <div class="section__inner">
        <div class="section__title">
            <h2 class="h2">Related links</h2>
        </div>
        <div class="section__body">
            <div class="link-block">
                <div class="links-block__inner">
                    <div class="_row">
                        @foreach(Help\ArrayClass::break_up($links, 3) as $links_re)
                            <div class="_col">
                                @foreach($links_re as $link)
                                    <a href="{{route('relate', ['related_link' => $link->slug])}}" class="_link">{{$link->title}}</a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>