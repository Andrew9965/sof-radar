<section class="section section--gray">
    <div class="container">
        <div class="section__inner">
            <div class="section__title">
                <h2 class="h2">Top-rated software solutions</h2>
            </div>
            <div class="section__body">
                <div class="_row row">

                    @foreach($top_soft as $soft)
                        @include('sections.soft.soft_item', ['soft' => $soft])
                        @if($loop->iteration % 4 == 0)
                            </div>
                            <div class="_row row  hidden-sm  hidden-xs">
                        @endif
                    @endforeach

                </div>
            </div>

            <div class="section__action section__action--center">
                <button class="btn btn-border btn-radius btn-radius--big btn-big">All top-rated software</button>
            </div>
        </div>
    </div>
</section>