@extends('layouts.app')

@section('content')

    <section class="section section--shadow section--gray-light">
        <div class="container">
            <div class="section__inner">
                <div class="section__body">
                    <div class="_row row">
                        <div class="col-md-12">
                            @include('sections.soft.review_item', ['r' => $review, 'fool' => true])
                        </div>
                    </div>
                </div>
                <div class="section__action section__action--center">
                    <button class="btn btn-border btn-radius btn-radius--big btn-big" data-popup="add-review">Add reviews</button>
                </div>
            </div>
        </div>
    </section>

    @include('sections.home.top_soft');

@endsection