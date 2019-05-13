@php
    $rout = \Route::currentRouteName();
    $seoPage = \App\Models\Pages::thisPage();
    if(isset($seoPage->meta_title)) $seoPage->meta_title = str_replace('[product_name]', isset($product) ? $product->title : '', $seoPage->meta_title);
    $seo = $seoPage;
    if(isset($category) && isset($category->meta_title)) $seo = $category;
    if(isset($product) && isset($product->meta_title)) $seo = $product;
    if(isset($review) && isset($review->meta_title)) $seo = $review;
    if(isset($compare) && isset($compare->meta_title)) $seo = $compare;
    if($rout=='user.index') {
        $seo->meta_title = Auth::user()->name;
    }
    $addTitle = '';
    $rout = \Route::currentRouteName();
    //dd($seoPage);
@endphp

    @if($rout=='product.news' && isset($product->id))
    <title>{{$seo->meta_title}} - News and Updates | Software Radar</title>
    @else
    <title>{{$seo->meta_title}}{{isset($seoPage->id) && $seoPage->meta_title!=$seo->meta_title && !empty($seoPage->meta_title) ? ' - '.$seoPage->meta_title : ''}} | Software Radar</title>
    @endif
    <meta name="author" content="BLAKIT, blak-it.com">
    <meta name="keywords" content="{{$seo->meta_keywords}}{{isset($seoPage->id) && $seoPage->meta_keywords!=$seo->meta_keywords ? ' '.$seoPage->meta_keywords : ''}}">
    <meta name="description" content="{{$seo->meta_description}}{{isset($seoPage->id) && $seoPage->meta_description!=$seo->meta_description ? (!empty($seoPage->meta_description) ? ' | ':'').$seoPage->meta_description : ''}}">

    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:image" content="">
    <meta property="og:url" content="">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:description" content="">
    <meta property="og:site_name" content="">
