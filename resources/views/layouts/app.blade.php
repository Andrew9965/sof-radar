<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('blocks.meta_seo')

    <link rel="shortcut icon" sizes="32x32" href="{{asset('images/meta/favicon.ico')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/lia/toastr/build/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/fontawesome-all.min.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>--}}
</head>
<body>
<div class="wrapper">
    @include('blocks.header')
    <div class="wrapper__inner">
        <div class="page-default">
            @yield('content')
        </div>
    </div>
    @include('blocks.footer')
</div>
@include('blocks.popups')
@stack('popups')
<script src="{{asset('js/libs/html5shiv.js')}}"></script>
<script src="{{asset('js/libs/jquery.js')}}"></script>
<script src="{{asset('js/libs/mousewheel.js')}}"></script>
<script src="{{asset('js/libs/slick.js')}}"></script>
<script src="{{asset('js/libs/jquery.mCustomScrollbar.js')}}"></script>
<script src="{{asset('js/libs/jquery.fancybox.js')}}"></script>
<script src="{{asset('js/libs/select2.full.js')}}"></script>
<script src="{{asset('js/libs/select2.js')}}"></script>
<script src="{{asset('js/libs/chart.js')}}"></script>
<script src="{{asset('js/helpers/layout.js')}}"></script>
<script src="{{asset('js/helpers/popups.js')}}"></script>
<script src="{{asset('js/js.cookie.js')}}"></script>
<script src="{{asset('vendor/lia/toastr/build/toastr.min.js')}}"></script>
<script src="{{asset('js/ui.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
@include('lia::partials.toastr')
<!-- endbuild -->
@stack('scripts')
@if($params_after_auth)
    <script>
        var saved = {!! $params_after_auth !!};
        $(function(){
            if(saved.open_add_review!=undefined && saved.open_add_review=='true'){
                //Popups.openById('add-review');
                $('#input-slider').trigger('click');
                if(saved.cat_slug!=undefined){
                    $('[name="category_id_for_selection_product"]').val(saved.cat_slug).trigger('change');
                    var timeOnutSelectProduct = setTimeout(function(){
                        $('[name="product_id"]').val(saved.prod_id).trigger('change');
                        clearTimeout(timeOnutSelectProduct);
                    }, 1000);
                }
            }
        });
    </script>
@endif

@include('blocks.messages')
</body>
</html>