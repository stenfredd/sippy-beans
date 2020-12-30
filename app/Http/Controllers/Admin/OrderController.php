<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomerOrderCancelled;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Origin;
use App\Models\Brand;
use App\Models\BrandType;
use App\Models\BestFor;
use App\Models\TaxClass;
use App\Models\Type;
use App\Models\CoffeeType;
use App\Models\CoffeeFlavor;
use App\Models\Level;
use App\Models\Image;
use App\Models\Process;
use App\Models\Grind;
use App\Models\Characteristic;
use App\Models\Promocode;
use App\Models\RedeemPromocode;
use App\Models\Weight;
use App\Models\Variant;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\UserAddress;
use App\Models\UserPromocode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::select('orders.*');
        if ($request->ajax()) {

            $user_id = $request->input('user_id');
            $status = $request->input('status');
            $orders = $orders->with('user')->latest();

            if (!empty($user_id)) {
                $orders = $orders->whereUserId($user_id);
            }
            if ($status !== null && $status > -1) {
                $orders = $orders->where('status', $status);
            }
            if(!empty($request->input('search')) && !is_array($request->input('search'))) {
                $orders = $orders->where(function($query) use ($request){
                    $query->where('id', 'LIKE', "%" . $request->input('search') . "%");
                    $query->orWhere('order_number', 'LIKE', "%" . $request->input('search') . "%");
                    $query->orWhereHas('user', function($qry) use($request) {
                        $qry->where('name', 'LIKE', "%" . $request->input('search') . "%");
                        $qry->orWhere('email', 'LIKE', "%" . $request->input('search') . "%");
                        $qry->orWhere('phone', 'LIKE', "%" . $request->input('search') . "%");
                    });
                });
            }
            $orders = $orders->get();

            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('customer_name', function ($order) {
                    return $order->user->name ?? '-';
                })
                ->editColumn('total_amount', function ($order) {
                    return ($this->app_settings['currency_code'] .' '. number_format($order->total_amount,2)) ?? '-';
                })
                ->addColumn('product_names', function ($order) {
                    $product_names = null;
                    if($order->order_type == 'subscription') {
                        $order->subscription = Subscription::whereStatus(1)->first();
                        $product_names = "SIPPY - " . ($order->subscription->title ?? '') . ' x1';
                    }
                    else {
                        foreach($order->details as $detail) {
                            if(!empty($detail->product) && isset($detail->product->product_name)) {
                                $name = ($detail->product->brand->name ?? '') .' - ' . $detail->product->product_name .' x'.$detail->quantity;
                                $product_names .= (!empty($product_names) ? ', ' : '') . $name;
                            }
                        }
                        // if(empty($product_names)) {
                            foreach($order->details as $detail) {
                                if(!empty($detail->equipment) && isset($detail->equipment->title)) {
                                    $name = ($detail->equipment->brand->name ?? '') .' - '. $detail->equipment->title .' x'.$detail->quantity;
                                    $product_names .= (!empty($product_names) ? ', ' : '') . $name;
                                }
                            }
                        // }
                    }
                    if(!empty($product_names) && strlen($product_names) >= 40) {
                        $product_names = substr($product_names, 0, 37) . '...';
                    }
                    return $product_names;
                })
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->timezone($this->app_settings['timezone'])->format("M d,Y h:iA") ?? '-';
                })
                ->addColumn('action', function ($order) {
                    $action = '<div class="d-inline-flex">';
                    $action .= '<a href="' . url('admin/orders/' . $order->id) . '"><i class="feather icon-eye"></i></a>';
                    $action .= "</div>";
                    return $action;
                })
                ->editColumn('payment_type', function($order) {
                    if(strtolower($order->payment_type) == 'card')
                        $payment_type = '<img src="'.asset('assets/images/'.$order->card_type.'.png').'"> <span>****'.ucfirst($order->card_number).'</span>';
                    else {
                        $payment_type = '<span>Cash On Delivery</span>';
                    }
                    return $payment_type;
                })
                ->rawColumns(['payment_type', 'action'])
                ->make(TRUE);
        }
        $all_orders = $orders->count();

        $new_orders = Order::whereStatus(0)->count();
        $inprogress_orders = Order::whereStatus(1)->count();
        $shipped_orders = Order::whereStatus(2)->count();
        $completed_orders = Order::whereStatus(3)->count();
        $cancelled_orders = Order::whereStatus(4)->count();

        $page_title = 'Sales Orders';
        view()->share('page_title', $page_title);

        return view('admin.orders.list', compact('new_orders', 'inprogress_orders', 'shipped_orders', 'completed_orders', 'cancelled_orders', 'all_orders'));
    }

    public function show(Request $request, $id = false)
    {
        $order = Order::select('*')->with(["transactions", 'activities', 'user', 'user.addresses'])
                    ->with(["details", 'details.product', 'details.equipment', 'details.subscription'])
                    // ->find($id) ?? [];
                    ->findOrFail($id);
        if(!empty($order)) {
            $order->total_discount = ($order->discount_type == 'percentage' ? (($order->subtotal / 100) * $order->discount_amount) : $order->discount_amount) + $order->promocode_discount;
            foreach($order->details as $detail) {
                $detail->grind_title = Grind::find($detail->grind_id)->title ?? null;
            }

            $order->total_refund = 0;
            $order->pending_refund = 0;
            $cancelled_items_amount = OrderDetail::whereOrderId($order->id)->whereIsCancelled(1)->sum('subtotal');
            if($cancelled_items_amount > 0) {
                if (OrderDetail::whereOrderId($order->id)->count() == OrderDetail::whereOrderId($order->id)->whereIsCancelled(1)->count()) {
                    if($order->pending_refund == 0) {
                        Order::find($order->id)->update(['payment_status' => 4]);
                    }
                    else {
                        Order::find($order->id)->update(['payment_status' => 3]);
                    }
                    $cancelled_items_amount = $cancelled_items_amount + $order->delivery_fee + $order->tax_charges;
                }
                $order->total_refund = Transaction::whereOrderId($order->id)->wherePaymentType('refund')->sum('amount');
                $order->pending_refund = $cancelled_items_amount - $order->total_refund;
            }

            $order->balance_amount = $order->total_amount - $order->payment_received - $order->total_discount - $cancelled_items_amount;
        }

        $users = User::whereStatus(1)->where('user_type', '!=', 'admin')->get();

        $page_title = (!empty($id) ? 'Order Details' : 'Add New Order');
        view()->share('page_title', $page_title);
        return view('admin.orders.show', compact('order', 'users'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'order_id' => 'required'
        ]);

        $request_data = $request->except(['_token', 'order_id']);
        if (empty($request_data) || count($request_data) == 0) {
            return response()->json(['status' => false, 'message' => 'Something went wrong, Please try again.']);
        }
        if (!empty($request->input('promocode'))) {
            $user_id = $request->user_id;

            $promocode_original = Promocode::wherePromocode($request->promocode)->first();
            if (empty($promocode_original) || !isset($promocode_original->id) || $promocode_original->status == 0 || strtotime($promocode_original->start_date) > strtotime(date("Y-m-d H:i:s"))) {
                $response = ['status' => false, 'message' => 'Invalid Promo Applied.'];
                return response()->json($response);
            }

            $promocode_end_date = Carbon::createFromFormat('Y-m-d H:i:s', $promocode_original->end_date, $this->app_settings['timezone'])->timezone('UTC')->format("Y-m-d H:i:s");
            if (strtotime($promocode_end_date) < strtotime(date("Y-m-d H:i:s"))) {
                $response = ['status' => false, 'message' => 'Sorry, the promo code applied has expired.'];
                return response()->json($response);
            }

            if ($promocode_original->used_limit > 0) {
                $user_promocodes = UserPromocode::where('promocode_id', $promocode_original->id)->count();
                if ($user_promocodes > 0) {
                    $user_promocodes = UserPromocode::wherePromocodeId($promocode_original->id)->whereUserId(auth('api')->user()->id)->count();
                    if ($user_promocodes == 0) {
                        $response = ['status' => false, 'message' => 'Invalid Promo Applied.'];
                        return response()->json($response);
                    }
                    $used_count = RedeemPromocode::whereUserId($user_id)->wherePromocode($promocode_original->promocode)->count();
                    if ($used_count >= $promocode_original->used_limit) {
                        $response = ['status' => false, 'message' => 'Promocode used limit reached.'];
                        return response()->json($response);
                    }
                } else {
                    $used_count = RedeemPromocode::wherePromocode($promocode_original->promocode)->count();
                    if ($used_count >= $promocode_original->used_limit) {
                        $response = ['status' => false, 'message' => 'Promocode used limit reached.'];
                        return response()->json($response);
                    }
                }
            }

            $order = Order::find($request->order_id);
            $promocode_discount_amount = ($promocode_original->type == 'percentage' ? (($order->subtotal / 100) * $promocode_original->promocode_amount) : $promocode_original->promocode_amount) ?? 0;
            RedeemPromocode::where('status', 0)->where('user_id', $user_id)->delete();
            RedeemPromocode::create([
                'user_id' => $user_id,
                'order_id' => $request->order_id,
                'promocode' => $promocode_original->promocode,
                'type' => $promocode_original->discount_type,
                'promocode_amount' => $promocode_original->discount_amount,
                'redeem_amount' => $promocode_discount_amount,
                'status' => 0
            ]);
        }

        $order = Order::find($request->order_id);
        $old_object = $order;
        if (isset($request->status) && !empty($request->status) && $request->status == 3) {
            $request_data['completion_date'] = date("Y-m-d H:i:s");
        }
        $order->update($request_data);
        if (isset($request->status) && !empty($request->status) && $request->status == 4) {

            $order = Order::whereUserId($user_id)
                ->with([
                    'user', 'address', 'details',
                    'details.product', 'details.variant', 'details.equipment', 'details.subscription',
                    'details.product.seller', 'details.equipment.seller',
                    'details.product.images', 'details.equipment.images'
                ])
                ->latest()
                ->find($order->id);
            $order->total_refund = Transaction::whereOrderId($order->id)->wherePaymentType('refund')->sum('amount');
            $order->balance = $order->total_amount - $order->payment_received - $order->total_refund;
            $order->total_discount = $order->promocode_discount ?? 0;
            if (!empty($order->discount_type) && !empty($order->discount_amount)) {
                $discount_amount = ($order->discount_type == 'percentage' ? (($order->total_amount / 100) * $order->discount_amount) : $order->discount_amount);
                $order->total_discount = $order->total_discount + $discount_amount;
            }
            $order->created_at_text = $order->created_at->timezone($this->app_settings['timezone'])->format("M d, Y, h:iA") ?? $order->created_at;
            $order->product_names = null;
            if ($order->order_type == 'subscription') {
                $order->product_names = $order->subscription->title ?? '';
            }
            else {
                foreach ($order->details as $detail) {
                    if (!empty($detail->product) && isset($detail->product->product_name)) {
                        $order->product_names = (!empty($order->product_names) ? ', ' : '') . $detail->product->product_name;
                    }
                }
                foreach ($order->details as $detail) {
                    if (!empty($detail->equipment) && isset($detail->equipment->title)) {
                        $order->product_names = (!empty($order->product_names) ? ', ' : '') . $detail->equipment->title;
                    }
                }
            }
            foreach ($order->details as $detail) {
                $detail->grind_title = Grind::find($detail->grind_id)->title ?? null;
            }
            $order->delivery_time = $order->address->city()->first()->delivery_time ?? '1-3 Business days';
            Mail::to($order->user->email)->queue(new CustomerOrderCancelled($order));
        }

        return response()->json(['status' => true, 'message' => 'Order details updated successfully.']);
    }

    public function cancelItems(Request $request) {
        $request->validate([
            'order_id' => 'required',
            'detail_ids' => 'required'
        ]);

        $order_id = $request->order_id;
        $detail_ids = explode(',', $request->detail_ids);

        $status = false;
        foreach($detail_ids as $detail_id) {
            $status = OrderDetail::find($detail_id)->update(['is_cancelled' => 1]);
        }

        if(OrderDetail::whereOrderId($order_id)->count() == OrderDetail::whereOrderId($order_id)->whereIsCancelled(1)->count()) {
            $status = Order::find($order_id)->update(['status' => 4]);
        }

        $order = Order::with([
                'user', 'address', 'details',
                'details.product', 'details.variant', 'details.equipment', 'details.subscription',
                'details.product.seller', 'details.equipment.seller',
                'details.product.images', 'details.equipment.images'
            ])
            ->latest()
            ->find($order_id);
        $order->total_refund = Transaction::whereOrderId($order->id)->wherePaymentType('refund')->sum('amount');
        $order->balance = $order->total_amount - $order->payment_received - $order->total_refund;
        $order->total_discount = $order->promocode_discount ?? 0;
        if (!empty($order->discount_type) && !empty($order->discount_amount)) {
            $discount_amount = ($order->discount_type == 'percentage' ? (($order->total_amount / 100) * $order->discount_amount) : $order->discount_amount);
            $order->total_discount = $order->total_discount + $discount_amount;
        }
        $order->created_at_text = $order->created_at->timezone($this->app_settings['timezone'])->format("M d, Y, h:iA") ?? $order->created_at;
        $order->product_names = null;
        if ($order->order_type == 'subscription') {
            $order->product_names = $order->subscription->title ?? '';
        }
        else {
            foreach ($order->details as $detail) {
                if (!empty($detail->product) && isset($detail->product->product_name)) {
                    $order->product_names = (!empty($order->product_names) ? ', ' : '') . $detail->product->product_name;
                }
            }
            foreach ($order->details as $detail) {
                if (!empty($detail->equipment) && isset($detail->equipment->title)) {
                    $order->product_names = (!empty($order->product_names) ? ', ' : '') . $detail->equipment->title;
                }
            }
        }
        foreach ($order->details as $detail) {
            $detail->grind_title = Grind::find($detail->grind_id)->title ?? null;
        }
        $order->delivery_time = $order->address->city()->first()->delivery_time ?? '1-3 Business days';
        Mail::to($order->user->email)->queue(new CustomerOrderCancelled($order, $detail_ids));

        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if($status) {
            $response = ['status' => true, 'message' => 'Selected item(s) has beed cancelled successfully.'];
        }
        return response()->json($response);
    }
}
