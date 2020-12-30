<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false
]);
Route::get('/', function() { return redirect('admin'); });

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/', 'HomeController@index')->name('home');

        // ---------------------- MASTERS SECTION START ---------------------- //

        Route::match(['get','post'], 'users', 'Admin\UserController@index');
        Route::post('users/create', 'Admin\UserController@create');
        // Route::post('users/delete', 'Admin\UserController@delete');
        Route::get("users/{id}", "Admin\UserController@show");

        Route::match(['get','post'], 'orders', 'Admin\OrderController@index');
        Route::post('orders/create', 'Admin\OrderController@create');
        Route::post('orders/update', 'Admin\OrderController@update');
        // Route::post('orders/delete', 'Admin\OrderController@delete');
        Route::get("orders/{id}", "Admin\OrderController@show");

        Route::match(['get', 'post'], 'banners', 'Admin\BannerController@index');
        Route::post('banners/save', 'Admin\BannerController@save');
        Route::post('banners/delete', 'Admin\BannerController@delete');
        Route::post('banners/update-sort-orders', 'Admin\BannerController@updateSortOrders');

        //BRANDS
        Route::match(['get', 'post'], 'brands', 'Admin\BrandController@index');
        Route::post('brands/save', 'Admin\BrandController@save');
        Route::post('brands/delete', 'Admin\BrandController@delete');
        // Route::post('brands/update-sort-orders', 'Admin\BrandController@updateSortOrders');
        //BRANDS ENDS

         //Sellers
         Route::match(['get', 'post'], 'sellers', 'Admin\SellerController@index');
         Route::post('sellers/save', 'Admin\SellerController@save');
         Route::post('sellers/delete', 'Admin\SellerController@delete');
        //  Route::post('sellers/update-sort-orders', 'Admin\SellerController@updateSortOrders');
         //Sellers ENDS

        //COFFEE FLAVOR
        Route::match(['get', 'post'], 'coffee_flavor', 'Admin\CoffeeFlavorController@index');
        Route::post('coffee_flavor/save', 'Admin\CoffeeFlavorController@save');
        Route::post('coffee_flavor/delete', 'Admin\CoffeeFlavorController@delete');
        // Route::post('coffee_flavor/update-sort-orders', 'Admin\CoffeeFlavorController@updateSortOrders');
        //COFFEE FLAVOR ENDS

        //COFFEE TYPE
        Route::match(['get', 'post'], 'coffee_type', 'Admin\CoffeeTypeController@index');
        Route::post('coffee_type/save', 'Admin\CoffeeTypeController@save');
        Route::post('coffee_type/delete', 'Admin\CoffeeTypeController@delete');
        // Route::post('coffee_type/update-sort-orders', 'Admin\CoffeeTypeController@updateSortOrders');
        //COFFEE TYPE END

        //Level
        Route::match(['get', 'post'], 'level', 'Admin\LevelController@index');
        Route::post('level/save', 'Admin\LevelController@save');
        Route::post('level/delete', 'Admin\LevelController@delete');
        // Route::post('level/update-sort-orders', 'Admin\LevelController@updateSortOrders');
        //Level ENDS

        //Origins
        Route::match(['get', 'post'], 'origin', 'Admin\OriginController@index');
        Route::post('origin/save', 'Admin\OriginController@save');
        Route::post('origin/delete', 'Admin\OriginController@delete');
        // Route::post('origin/update-sort-orders', 'Admin\OriginController@updateSortOrders');
        //Origins ENDS

        //Types
        Route::match(['get', 'post'], 'type', 'Admin\TypeController@index');
        Route::post('type/save', 'Admin\TypeController@save');
        Route::post('type/delete', 'Admin\TypeController@delete');
        // Route::post('type/update-sort-orders', 'Admin\TypeController@updateSortOrders');
        //Types ENDS

        //WEIGHTS
        Route::match(['get', 'post'], 'weight', 'Admin\WeightController@index');
        Route::post('weight/save', 'Admin\WeightController@save');
        Route::post('weight/delete', 'Admin\WeightController@delete');
        // Route::post('weight/update-sort-orders', 'Admin\WeightController@updateSortOrders');
        //WEIGHTS ENDS

        //Process
        Route::match(['get', 'post'], 'process', 'Admin\ProcessController@index');
        Route::post('process/save', 'Admin\ProcessController@save');
        Route::post('process/delete', 'Admin\ProcessController@delete');
        // Route::post('process/update-sort-orders', 'Admin\ProcessController@updateSortOrders');
        //Process ENDS

        //Characteristics
        Route::match(['get', 'post'], 'characteristics', 'Admin\CharacteristicController@index');
        Route::post('characteristics/save', 'Admin\CharacteristicController@save');
        Route::post('characteristics/delete', 'Admin\CharacteristicController@delete');
        // Route::post('characteristics/update-sort-orders', 'Admin\CharacteristicController@updateSortOrders');
        //Characteristics ENDS

        //SUBSCRIPTION
        Route::match(['get', 'post'], 'subscription', 'Admin\SubscriptionController@index');
        Route::post('subscription/save', 'Admin\SubscriptionController@save');
        Route::post('subscription/delete', 'Admin\SubscriptionController@delete');
        // Route::post('subscription/update-sort-orders', 'Admin\SubscriptionController@updateSortOrders');
        //SUBSCRIPTION ENDS

        //BEST_FOR
        Route::match(['get', 'post'], 'best_for', 'Admin\BestForController@index');
        Route::post('best_for/save', 'Admin\BestForController@save');
        Route::post('best_for/delete', 'Admin\BestForController@delete');
        // Route::post('best_for/update-sort-orders', 'Admin\BestForController@updateSortOrders');
        //BEST_FOR ENDS


        //MATCHMAKER
        Route::match(['get', 'post'], 'match_maker', 'Admin\MatchMakerController@index');
        Route::post('match_maker/save', 'Admin\MatchMakerController@save');
        Route::post('match_maker/delete', 'Admin\MatchMakerController@delete');
        // Route::post('match_maker/update-sort-orders', 'Admin\MatchMakerController@updateSortOrders');
        //MATCHMAKER ENDS

        //GRINDS
        Route::match(['get', 'post'], 'grinds', 'Admin\GrindController@index');
        Route::post('grinds/save', 'Admin\GrindController@save');
        Route::post('grinds/delete', 'Admin\GrindController@delete');
        // Route::post('grinds/update-sort-orders', 'Admin\GrindController@updateSortOrders');
        //GRINDS ENDS

        //PRODUCTS
        Route::match(['get', 'post'], 'products', 'Admin\ProductController@index');
        Route::get('products/create','Admin\ProductController@create');
        Route::post('products/store','Admin\ProductController@store');
        Route::post('products/update','Admin\ProductController@update');
        Route::post('products/delete', 'Admin\ProductController@delete');
        Route::get('products/{id}','Admin\ProductController@details');
        // Route::post('products/update-sort-orders', 'Admin\ProductController@updateSortOrders');
        //PRODUCTS ENDS

        //EQUIPMENTS
        Route::match(['get', 'post'], 'equipments', 'Admin\EquipmentController@index');
        Route::get('equipment_create_edit', 'Admin\EquipmentController@equipment_create_edit');
        Route::get('equipment_create_edit/{id}', 'Admin\EquipmentController@equipment_create_edit');
        Route::post('equipment_create_edit', 'Admin\EquipmentController@save');
        Route::post('equipments/delete', 'Admin\EquipmentController@delete');
        // Route::post('equipments/update-sort-orders', 'Admin\EquipmentController@updateSortOrders');
        //EQUIPMENTS ENDS

        Route::match(['get', 'post'], 'promocodes', 'Admin\PromocodeController@index');
        Route::post('promocodes/save', 'Admin\PromocodeController@save');
        Route::post('promocodes/delete', 'Admin\PromocodeController@delete');

        // ---------------------- MASTERS SECTION END ---------------------- //

        // ---------------------- LOCATIONS MANAGER SECTION START ---------------------- //
        Route::match(['get', 'post'], 'countries', 'Admin\CountryController@index');
        Route::post('countries/save', 'Admin\CountryController@save');
        Route::post('countries/delete', 'Admin\CountryController@delete');

        Route::match(['get', 'post'], 'cities', 'Admin\CityController@index');
        Route::post('cities/save', 'Admin\CityController@save');
        Route::post('cities/delete', 'Admin\CityController@delete');
        // ---------------------- LOCATIONS MANAGER SECTION END ---------------------- //


        // ---------------------- MODULES SECTION START ---------------------- //
        // SET MODULES HERE
        // ---------------------- MODULES SECTION END ---------------------- //

        // ---------------------- PAGES SECTION START ---------------------- //

        Route::match(['get', 'post'], 'contact-us', 'Admin\PageController@contactUs');
        Route::match(['get', 'post'], 'faq', 'Admin\PageController@faq');
        Route::match(['get', 'post'], 'privacy-policies', 'Admin\PageController@privacyPolicy');
        Route::match(['get', 'post'], 'terms-conditions', 'Admin\PageController@termsConditions');

        // ---------------------- PAGES SECTION END ---------------------- //

        Route::get('settings', 'Admin\SettingController@index');
        Route::post('settings', 'Admin\SettingController@save');
    });
});

Route::get('/subscription/create', 'User\SubscriptionController@index')->name('subscription.create');
Route::any('stripe/callback', 'Server\StripeController@webhookCallback');

Route::get('test-push', function() {
    \OneSignal::sendNotificationToUser("New push messgae", "ececda29-6213-4fa4-9abd-42df7e3e7c9e", $url = url('/admin'), $data = ['test' => 'test']);
});

Route::get('send_test_email', function(){
	Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)
	{
        $message->subject('Mailgun and Laravel are awesome!');
		$message->from('no-reply@hypeten.com', 'Sippy Beans');
		$message->to('sonitejas9033@gmail.com');
	});
});
