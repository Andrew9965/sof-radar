@extends('layouts.soft')

@section('soft-content')

    @php
        $cat = $categories->firstWhere('id', $product->category_1);
    @endphp
    @if($cat)
    <div class="review-info">
        <div class="container">
            <div class="review-info__inner">
                <div class="row">
                    <div class="col-lg-5 _col">
                        <div class="review-info__img js-chart">
                            <!--<canvas id="myChart" width="100%" height="100%"></canvas>-->
                            <div id="container" style="margin: 0 auto;"></div>
                        </div>
                    </div>
                    @php
                        $needle_fields = ['easy_of_use', 'functionality', 'product_quality', 'customer_support', 'value_for_money', 'review_rait_total', 'review_count'];
                        $cat_prods = collect([$cat->prods_1, $cat->prods_2, $cat->prods_3])->collapse()->map(function($item) use ($needle_fields){
                            return $item->only($needle_fields);
                        });

                        $results = [];
                        foreach ($cat_prods as $key => $val) {
                            foreach ($val as $fi => $num){
                                if (isset($cat_prods[$key][$fi]) && is_numeric($cat_prods[$key][$fi])) {
                                    $val = $fi!=='review_rait_total' ? ($cat_prods[$key]['review_count'] ? $cat_prods[$key][$fi] / $cat_prods[$key]['review_count'] : 0) : $cat_prods[$key][$fi];
                                    $results[$fi] = $val;
                                }
                            }
                        }

                        foreach($results as $key=>$val) $results[$key] = $results[$key]/$cat_prods->count();

                        $cat_rait = explode('.', $results['review_rait_total']);
                        $product_rait = explode('.', $product->review_rait_total);
                    @endphp
                    <div class="col-lg-7 _col">
                        <div class="review-info__item">
                            <div class="review-info__desc">
                                <div class="review-info__title" style="border-color: #ff1b4b">{{$cat->title}}</div>
                                <div class="review-info__total">
                                    <div class="rating-total__value {{$ctrl->getColorAttribute($results['review_rait_total'])}} ">
                                        <span class="_label">{{$cat_rait[0]}}</span>{{isset($cat_rait[1]) ? '.'.substr($cat_rait[1], 0, 2) : ''}}/5
                                    </div>
                                </div>
                            </div>
                            <div class="review-info__rating">

                                <div class="rating-all">
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Easy-of-use:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" style="width: {{(100/5)*$results['easy_of_use']}}%"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Functionality:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" style="width: {{(100/5)*$results['functionality']}}%"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Product Quality:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" style="width: {{(100/5)*$results['product_quality']}}%"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Customer Support:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" style="width: {{(100/5)*$results['customer_support']}}%"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Value for Money:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" style="width: {{(100/5)*$results['value_for_money']}}%"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="review-info__item">
                            <div class="review-info__desc">
                                <div class="review-info__title" style="border-color: #eec92a">{{$product->title}}</div>
                                <div class="review-info__total">
                                    <div class="rating-total__value {{$product->getColorAttribute()}} ">
                                        <span class="_label">{{$product_rait[0]}}</span>{{isset($product_rait[1]) ? '.'.substr($product_rait[1], 0, 2) : ''}}/5
                                    </div>
                                </div>
                            </div>
                            <div class="review-info__rating">

                                <div class="rating-all">
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Easy-of-use:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" style="width: {{$product->review_count ? (100/5)*($product->easy_of_use/$product->review_count) : 0}}%"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Functionality:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" style="width: {{$product->review_count ? (100/5)*($product->functionality/$product->review_count) : 0}}%"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Product Quality:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" style="width: {{$product->review_count ? (100/5)*($product->product_quality/$product->review_count) : 0}}%"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Customer Support:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" style="width: {{$product->review_count ? (100/5)*($product->customer_support/$product->review_count) : 0}}%"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="_item">
                                        <div class="rating">
                                            <div class="rating__inner">
                                                <div class="rating__info">
                                                    <div class="rating__label ">Value for Money:</div>

                                                    <div class="rating__star rating__star--mt">
                                                        <div class="rating-star rating-star--small">
                                                            <div class="rating-star__inner">
                                                                <div class="rating-star__empty"></div>
                                                                <div class="rating-star__fill" style="width: {{$product->review_count ? (100/5)*($product->value_for_money/$product->review_count) : 0}}%"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    @endif
    <section class="section section--shadow">
        <div class="container">
            <div class="section__inner">
                <div class="section__title">
                    <h1>{{$product->title}} Reviews</h1>
                </div>

                <div class="section__body">

                    @foreach($reviews = \App\Models\Reviews::where('status', 1)->where('product_id', $product->id)->orderBy('like', 'desc')->paginate(6) as $r)
                        @include('sections.soft.review_item', ['r' => $r])
                    @endforeach

                    <div class="section__action section__action--col_m">
                        {{ $reviews->links() }}
                        <div class="_action">
                            <button class="btn btn-purple btn-add" data-popup="add-review"><i></i>Add reviews</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@if($cat)
@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script>
    var categoriesChart = {0:'Easy-of-use', 72:'Functionality', 144:'Product Quality', 216:'Customer Support', 288:'Value for Money'};
    Highcharts.chart('container', {
        chart: {
            polar: true
        },
        title: {
            text: ''
        },
        pane: {
            startAngle: 0,
            endAngle: 360
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        xAxis: {
            tickInterval: 72,
            min: 0,
            max: 360,
            labels: {
                rotation: 'auto',
                align: 'center',
                formatter: function () {
                    return categoriesChart[this.value];
                }
            }
        },
        yAxis: {
            min: 0,
            visible: false
        },
        plotOptions: {
            series: {
                pointStart: 0,
                pointInterval: 72
            },
            column: {
                pointPadding: 0,
                groupPadding: 0
            }
        },

        tooltip: {
            formatter: function() {
                return categoriesChart[this.x] + '<br><span style="fill:'+this.color+'">●</span> '+ this.series.name + ' :<b>'+this.y+'</b>';
            }
        },

        series: [
            {
                type: 'line',
                name: '{{$product->title}}',
                data: [
                    {{$product->review_count ? substr($product->easy_of_use/$product->review_count, 0, 3):0}},
                    {{$product->review_count ? substr($product->functionality/$product->review_count, 0, 3):0}},
                    {{$product->review_count ? substr($product->product_quality/$product->review_count, 0, 3):0}},
                    {{$product->review_count ? substr($product->customer_support/$product->review_count, 0, 3):0}},
                    {{$product->review_count ? substr($product->value_for_money/$product->review_count, 0, 3):0}}
                ],
                lineColor: "#efc92b",
                color: "#efc92b"
            },
            {
                type: 'area',
                name: '{{$cat->title}}',
                data: [
                    {{substr($results['easy_of_use'], 0, 3)}},
                    {{substr($results['functionality'], 0, 3)}},
                    {{substr($results['product_quality'], 0, 3)}},
                    {{substr($results['customer_support'], 0, 3)}},
                    {{substr($results['value_for_money'], 0, 3)}}
                ],
                lineColor: "#ff1b4b",
                fillColor: "rgba(255,27,75,0.2)",
                color: "#ff1b4b"
            }
        ]
    });
</script>
@endpush
@endif