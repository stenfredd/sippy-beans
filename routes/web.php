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
        Route::post('orders/add-transaction', 'Admin\OrderController@addTransaction');
        Route::post('orders/delete-transaction', 'Admin\OrderController@deleteTransaction');
        Route::get("orders/{id}", "Admin\OrderController@show");

        Route::match(['get', 'post'], 'products', 'Admin\ProductController@index');
        Route::post('products/save', 'Admin\ProductController@save');
        Route::post('products/variants/create', 'Admin\ProductController@createVariants');
        Route::post('products/variants/save', 'Admin\ProductController@saveVariants');
        Route::post('products/variants/delete', 'Admin\ProductController@deleteVariant');
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
        Route::post('categories/update-products-sort-orders', 'Admin\CategoryController@updateProductsSortOrders');
        Route::post('categories/delete', 'Admin\CategoryController@delete');
        Route::post('categories/remove-product', 'Admin\CategoryController@removeProduct');
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
        Route::post('promo-offers/save', 'Admin\PromocodeController@save');
        Route::post('promo-offers/update', 'Admin\PromocodeController@update');
        Route::get("promo-offers/{id}", "Admin\PromocodeController@show");

        Route::match(['get', 'post'], 'match-makers', 'Admin\MatchMakerController@index');
        Route::post('match-makers/save', 'Admin\MatchMakerController@save');
        Route::post('match-makers/delete', 'Admin\MatchMakerController@delete');

        Route::match(['get', 'post'], 'delivery-areas', 'Admin\PageController@deliveryAreas');
        Route::post('delivery-areas/update-sort-orders', 'Admin\PageController@updateAreasSortOrders');
        Route::get('delivery-areas/{id}', 'Admin\PageController@editDeliveryAreass');

        Route::match(['get', 'post'], 'tax-charges', 'Admin\PageController@taxCharges');

        Route::get('service-policies', 'Admin\PageController@index');
        Route::post('service-policies', 'Admin\PageController@save');
    });
});

// Stripe Callback
Route::get('/subscription/create', 'User\SubscriptionController@index')->name('subscription.create');
Route::any('stripe/callback', 'Server\StripeController@webhookCallback');



Route::any('test-email', function() {

    \OneSignal::sendNotificationToUser("test", "357FB70B-F2C9-4E98-9B89-6CB86EC79A74", null, ['order_id' => 1]);
    die;


    $order = Order::inRandomOrder()
        ->with([
            'user', 'address', 'details',
            'details.product', 'details.variant', 'details.equipment', 'details.subscription',
            'details.product.seller', 'details.equipment.seller',
            'details.product.images', 'details.equipment.images'
        ])
        ->first();

    $order->total_refund = Transaction::wherePaymentType('refund')->sum('amount');
    $order->balance = $order->total_amount - $order->payment_received - $order->total_refund;
    $order->total_discount = $order->promocode_amount ?? 0;
    if (!empty($order->discount_type) && !empty($order->discount_amount)) {
        $discount_amount = ($order->discount_type == 'percentage' ? (($order->total_amount / 100) * $order->discount_amount) : $order->discount_amount);
        $order->total_discount = $order->total_discount + $discount_amount;
    }
    $order->created_at_text = $order->created_at->format("M d, Y, h:iA") ?? $order->created_at;
    $order->product_names = null;
    if ($order->order_type == 'subscription') {
        $order->product_names = $order->subscription->title ?? '';
    } else {
        foreach ($order->details as $detail) {
            if (!empty($detail->product) && isset($detail->product->product_name)) {
                $order->product_names = (!empty($order->product_names) ? ', ' : '') . $detail->product->product_name;
            }
        }
        // if(empty($order->product_names)) {
        foreach ($order->details as $detail) {
            if (!empty($detail->equipment) && isset($detail->equipment->title)) {
                $order->product_names = (!empty($order->product_names) ? ', ' : '') . $detail->equipment->title;
            }
        }
        // }
    }
    foreach ($order->details as $detail) {
        $detail->grind_title = Grind::find($detail->grind_id)->title ?? null;
    }
    $order->delivery_time = $order->address->city()->first()->delivery_time ?? '1-3 Business days';

    // Mail::to('sonitejas9033@gmail.com')->queue(new CustomerNewOrder($order));
    Mail::to('sonitejas9033@gmail.com')->queue(new AppNewOrder($order));
    return view('emails.sippy-new-order', compact('order'));

    $seller_details = [];
    foreach ($order->details as $detail) {
        if (!empty($detail->subscription_id)) {
            continue;
        }
        if (!empty($detail->equipment_id)) {
            $commission_fee = 0;
            if ($detail->equipment->commission_type === 'percentage') {
                $commission_fee = ($detail->subtotal / 100) * $detail->equipment->commission_fee;
            } else {
                $commission_fee = $detail->equipment->commission_fee * $detail->quantity;
            }
            $detail->seller_price = $detail->subtotal - $commission_fee;
            $seller_details[$detail->equipment->seller->id][] = $detail;
        }
        if (!empty($detail->product_id)) {
            $commission_fee = 0;
            if ($detail->product->commission_type === 'percentage') {
                $commission_fee = ($detail->subtotal / 100) * $detail->product->commission_fee;
            } else {
                $commission_fee = $detail->product->commission_fee * $detail->quantity;
            }
            $detail->seller_price = $detail->subtotal - $commission_fee;
            $seller_details[$detail->product->seller->id][] = $detail;
        }
    }

    if (!empty($seller_details)) {
        foreach ($seller_details as $seller_id => $details) {
            $seller = Seller::find($seller_id);
            $order->seller_total = array_sum(array_column($details, "seller_price"));
            Mail::to('sonitejas9033@gmail.com')->queue(new MerchantNewOrder($order, $details, $seller));
        }
    }
});
