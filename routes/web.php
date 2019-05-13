<?php
Auth::routes();

Route::group(['middleware' => ['web', 'auth'], 'as' => 'user.', 'prefix' => 'cabinet'], function(){
    Route::get('/', 'UserController@index')->name('index');
    Route::post('logout', '\App\Http\Controllers\Auth\LoginController@logout');
});

Route::group(['middleware' => ['web', 'auth'], 'as' => 'api.', 'prefix' => 'api', 'namespace' => 'Api'], function(){
    Route::post('/save_profile', 'ProfileController@save_profile')->name('save_profile');
    Route::post('/get_reviews', 'ProfileController@get_reviews')->name('get_reviews');
    Route::post('/save_review', 'ProfileController@save_review')->name('save_review');
    Route::post('/get_products', 'ProfileController@get_products')->name('get_products');
    Route::post('/file_uploader', 'ProfileController@file_uploader')->name('file_uploader');
    Route::get('/get_categories', 'ProfileController@get_categories')->name('get_categories');
    Route::get('/get_product', 'ProfileController@get_product')->name('get_product');
    Route::post('/save_product', 'ProfileController@save_product')->name('save_product');
    Route::post('/get_transaction/{id}', 'ProfileController@get_transaction')->name('get_transaction');
    Route::post('/get_transactions', 'ProfileController@get_transactions')->name('get_transactions');
    Route::get('/get_statistics', 'ProfileController@get_statistics')->name('get_statistics');
    Route::get('/get_new_statistic', 'ProfileController@get_new_statistic')->name('get_new_statistics');
    Route::get('/get_date_statistic', 'ProfileController@get_date_statistic')->name('get_date_statistic');

    Route::group(['as' => 'payment.'], function(){
        Route::post('/payment', 'PaymentController@index')->name('index');
    });
});

Route::group(['middleware' => 'web'], function(){

    Route::post('/payment', 'Api\PaymentController@hook')->name('payment_hook');
    Route::get('/payment/{transactions}/cancel', 'Api\PaymentController@cancel')->name('payment_cancel');
    Route::get('/payment/{transactions}/return', 'Api\PaymentController@return_action')->name('payment_return');

    Route::get('/', 'HomeController@index')->name('home');
    //Route::get('/test', 'HomeController@test')->name('test');
    Route::get('/search', 'SearchController@index')->name('search');
    Route::get('/search/product', 'SearchController@product')->name('search.product');
    Route::get('category/{categories}', 'CategoryController@index')->name('category');
    //Route::get('relate/{related_links}', 'RelatedController@index')->name('relate');
    Route::get('category/{categories}/news', 'NewsController@category_news')->name('category.news');
    Route::get('category/{product_id}/ajax', 'CategoryController@ajax_products')->name('category.ajax.products');
    Route::get('categories', 'CategoryController@fool_list')->name('categories');
    Route::get('app/top', 'ProductsController@top')->name('products.top');

    Route::group(['middleware' => 'tracker'], function() {
        Route::get('app/link/{product_id}', 'ProductsController@link')->name('product.link');
    });

    Route::get('app/compare_item/{product}', 'ProductsController@compare_item')->name('product.compare_item');
    Route::get('app/{product}', 'ProductsController@index')->name('product');
    Route::get('app/{product}/use', 'ProductsController@already_use')->name('product.use');
    Route::get('app/{product}/reviews', 'ProductsController@reviews')->name('product.reviews');
    Route::post('app/{product}/reviews', 'ProductsController@reviews_post')->name('product.reviews.post');
    Route::get('app/{product}/reviews/{review}', 'ProductsController@review')->name('product.review');
    Route::get('app/{product}/news', 'NewsController@index')->name('product.news');
    Route::get('app/{product}/news/{product_new}', 'NewsController@view')->name('product.new');

    Route::post('app/{review}/reviews/like', 'ProductsController@reviews_like')->name('product.like');
    Route::post('app/reviews/post', 'ProductsController@reviews_post_undefined')->name('product.reviews.post.und');
    Route::get('app/{product}/media', 'ProductsController@media')->name('product.media');
    Route::get('app/{product}/alternative', 'ProductsController@alternative')->name('product.alternative');
    Route::get('app/{product}/compare', 'ProductsController@compare')->name('product.compare');
    Route::get('news', 'NewsController@index')->name('product.news.all');

    Route::get('compare/new/{left}/{right}', 'CompareController@newCompare')->name('compare.new');
    Route::get('compare/{compare}', 'CompareController@index')->name('compare');

    Route::get('related/{related_links}', 'RelatedController@index')->name('relate');
    Route::get('/{page}', 'PageController@index')->name('page');

    Route::post('app/{review}/reviews/edit', 'ProductsController@reviews_post_edit')->name('product.reviews.post.edit');
});

Route::group(['middleware' => ['web', 'guest'], 'as' => 'social.', 'namespace' => 'Auth', 'prefix' => 'auth'], function(){
    Route::get('google', ['as' => 'google', 'uses' => 'GoogleController@index']);
    Route::get('facebook', 'FacebookController@index')->name('facebook');
    Route::get('google/cb', 'GoogleController@cb')->name('google.cb');
    Route::get('facebook/cb', 'FacebookController@cb')->name('facebook.cb');
});