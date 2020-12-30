<?php

use App\Mail\AppNewOrder;
use App\Mail\CustomerNewOrder;
use App\Mail\MerchantNewOrder;
use App\Models\Grind;
use App\Models\Order;
use App\Models\Seller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false
]);
Route::get('/', function () {
    return redirect('admin');
});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::post('/top-5-summary', 'HomeController@top5Summary');
        Route::post('/dashboard-summary', 'HomeController@dashboardSummary');

        Route::match(['get', 'post'], 'users', 'Admin\UserController@index');
        Route::post('users/update', 'Admin\UserController@update');
        Route::get('users/export', 'Admin\UserController@export');
        Route::get("users/{id}", "Admin\UserController@show");

        Route::match(['get', 'post'], 'orders', 'Admin\OrderController@index');
        Route::post('orders/create', 'Admin\OrderController@create');
        Route::post('orders/update', 'Admin\OrderController@update');
        Route::post('orders/cancel-items', 'Admin\OrderController@cancelItems');
        Route::get("orders/{id}", "Admin\OrderController@show");

        Route::match(['get', 'post'], 'products', 'Admin\ProductController@index');
        Route::post('products/save', 'Admin\ProductController@save');
        Route::post('products/variants/create', 'Admin\ProductController@createVariants');
        Route::post('products/variants/save', 'Admin\ProductController@saveVariants');
        Route::get("products/{id}", "Admin\ProductController@show");

        Route::match(['get', 'post'], 'equipments', 'Admin\EquipmentController@index');
        Route::post('equipments/save', 'Admin\EquipmentController@save');
        Route::get("equipments/{id}", "Admin\EquipmentController@show");

        Route::match(['get', 'post'], 'subscription', 'Admin\SubscriptionController@index');
        Route::post('subscription/save', 'Admin\SubscriptionController@save');
        Route::get("subscription/{id}", "Admin\SubscriptionController@show");

        Route::match(['get', 'post'], 'categories', 'Admin\CategoryController@index');
        Route::post('categories/save', 'Admin\CategoryController@save');
        Route::post('categories/update-sort-orders', 'Admin\CategoryController@updateSortOrders');
        Route::post('categories/delete', 'Admin\CategoryController@delete');
        Route::get("categories/{id}", "Admin\CategoryController@show");

        Route::match(['get', 'post'], 'attributes', 'Admin\AttributeController@index');
        Route::post('attributes/save', 'Admin\AttributeController@save');
        Route::post('attributes/delete', 'Admin\AttributeController@delete');
        Route::post('attributes/update-sort-orders', 'Admin\AttributeController@updateSortOrders');
        Route::get("attributes/{id}", "Admin\AttributeController@show");
        // Route::post('attributes/update', 'Admin\AttributeController@update');

        Route::match(['get', 'post'], 'banners', 'Admin\BannerController@index');
        Route::get('banners/create', 'Admin\BannerController@show');
        Route::post('banners/save', 'Admin\BannerController@save');
        Route::post('banners/delete', 'Admin\BannerController@delete');
        Route::post('banners/update-sort-orders', 'Admin\BannerController@updateSortOrders');
        Route::get('banners/{id}', 'Admin\BannerController@show');

        Route::match(['get', 'post'], 'promo-offers', 'Admin\PromocodeController@index');
        Route::post('promo-offers/create', 'Admin\PromocodeController@create');
        Route::post('promo-offers/update', 'Admin\PromocodeController@update');
        Route::get("promo-offers/{id}", "Admin\PromocodeController@show");

        Route::match(['get', 'post'], 'match-makers', 'Admin\MatchMakerController@index');
        Route::post('match-makers/save', 'Admin\MatchMakerController@save');
        Route::post('match-makers/delete', 'Admin\MatchMakerController@delete');

        Route::match(['get', 'post'], 'delivery-areas', 'Admin\PageController@deliveryAreas');
        Route::post('delivery-areas/update-sort-orders', 'Admin\PageController@updateAreasSortOrders');
        Route::get('delivery-areas/{id}', 'Admin\PageController@editDeliveryAreass');

        Route::match(['get', 'post'], 'tax-charges', 'Admin\PageController@taxCharges');
        // Route::match(['get', 'post'], 'service-policies', 'Admin\PageController@servicePolicies');

        Route::get('service-policies', 'Admin\PageController@index');
        Route::post('service-policies', 'Admin\PageController@save');
    });
});

// Stripe Callback
Route::get('/subscription/create', 'User\SubscriptionController@index')->name('subscription.create');
Route::any('stripe/callback', 'Server\StripeController@webhookCallback');

Route::get('test-push', function () {
    \OneSignal::sendNotificationToUser("New push messgae", "ececda29-6213-4fa4-9abd-42df7e3e7c9e", $url = url('/admin'), $data = ['test' => 'test']);
});
