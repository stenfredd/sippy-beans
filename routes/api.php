<?php

use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::post('login', 'API\AuthController@login');
Route::post('signup', 'API\AuthController@signup');
Route::post('apple-account-exist', 'API\AuthController@checkSocialLoginExist');
Route::post('social-login-register', 'API\AuthController@socialLoginRegister');
Route::post('forgot-password', 'API\AuthController@forgotPassword');

// Home Page
Route::post('home', 'API\ApplicationController@home');
Route::post('search', 'API\ApplicationController@search');

// Pages
Route::post('pages', 'API\ApplicationController@pages');

// Locations
Route::post('locations/countries', 'API\LocationController@countries');
Route::post('locations/cities', 'API\LocationController@cities');

// Filters
Route::post('filters', 'API\FilterController@get');

// Products
Route::post('products', 'API\ProductController@get');

// Equipments
Route::post('equipments', 'API\EquipmentController@get');

// Subscription
Route::post('subscription', 'API\SubscriptionController@index');

Route::middleware('auth:api')->group(function () {

    // Logout
    Route::get('logout', 'API\AuthController@logout');

    // User profile
    Route::get('profile', 'API\UserController@profile');
    Route::post('update-profile', 'API\UserController@updateProfile');

    // Match Maker
    Route::get('match-makers', 'API\MatchMakerController@index');
    Route::post('match-makers/update', 'API\MatchMakerController@update');

    // Cart
    Route::post('cart/get', 'API\CartController@index');
    Route::post('cart/update', 'API\CartController@update');
    Route::post('cart/delete', 'API\CartController@delete');

    // Orders
    Route::post('orders/get', 'API\OrderController@index');
    Route::post('orders/place', 'API\OrderController@store');

    // User Favourites
    Route::post('favourites/get', 'API\FavouriteController@get');
    Route::post('favourites/add-remove', 'API\FavouriteController@createUpdate');

    // Address
    Route::post('user/address/get', 'API\UserController@getAddress');
    Route::post('user/address/save', 'API\UserController@saveAddress');
    Route::post('user/address/delete', 'API\UserController@deleteAddress');

    // Promocode
    Route::post('promocode/apply', 'API\PromocodeController@apply');
    Route::post('promocode/remove', 'API\PromocodeController@remove');

    // Subscription
    // Route::post('subscription', 'API\SubscriptionController@index');
    Route::post('subscription/create', 'API\SubscriptionController@create');
    Route::post('subscription/cancel', 'API\SubscriptionController@cancel');
});
