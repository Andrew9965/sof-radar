<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('/dashboard', 'DashBoardController@index');
    $router->get('/dashboard/get_new_statistic', 'DashBoardController@get_new_statistic');
    $router->get('/dashboard/get_date_statistic', 'DashBoardController@get_date_statistic');
    $router->get('/dashboard/get_product', 'DashBoardController@get_product');
    $router->resource('/pages', PagesController::class);
    $router->resource('/categories', CategoriesController::class);

    $router->get('/products/news/{product}/{product_news?}', 'ProductNewsController@index')->name('admin.product.news');
    /*$router->post('/products/media/{product}/{product_news?}', 'ProductNewsController@save')->name('admin.product.news.post');
    $router->put('/products/media/{product}/{product_news?}', 'ProductNewsController@save')->name('admin.product.news.put');*/
    $router->match(['POST', 'PUT'], '/products/news/{product}/{product_news?}', 'ProductNewsController@save')->name('admin.product.news.post');
    $router->delete('/products/news/{product}/{product_news}', 'ProductNewsController@delete')->name('admin.product.news.delete');

    $router->get('/products/media/{product}/{product_media?}', 'ProductsController@media_index')->name('admin.product.media');
    $router->post('/products/media/{product}/{product_media?}', 'ProductsController@mediaSave')->name('admin.product.media.post');
    $router->delete('/products/media/{product}/{product_media}', 'ProductsController@mediaDelete')->name('admin.product.media.delete');

    $router->resource('/products', ProductsController::class);
    $router->resource('/type_category', CategoryTypeController::class);
    $router->resource('/reviews', ReviewsController::class);
    $router->resource('/related_links', RelatedLinksController::class);
    $router->post('/products/event', "ProductsController@formEvent")->name('product.event.post');

    $router->resource('options', OptionsController::class);
    $router->resource('bottom_menu', BottomMenuController::class);
    $router->resource('compares', ComparesController::class);
    $router->resource('banners', BannersController::class);
    $router->resource('users', UsersController::class);
    $router->get('users/auth/{user}', 'UsersController@auth')->name('admin.user.auth');

    $router->group(['prefix' => 'remote', 'as' => 'remote.'], function () {
        Route::match(['get'], '/get/{name}', 'RemoteDataControler@get')->name('get');
        Route::match(['get'], '/select/{name}', 'RemoteDataControler@select')->name('select');
        Route::match(['post'], '/insert/{name}', 'RemoteDataControler@insert')->name('insert');
        Route::match(['post'], '/update/{name}', 'RemoteDataControler@update')->name('update');
        Route::match(['delete'], '/delete/{name}', 'RemoteDataControler@delete')->name('delete');
    });

});
