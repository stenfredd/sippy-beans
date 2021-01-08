<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\User;
use App\Models\Setting;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $db_settings = Setting::all();
        if (!empty($db_settings) && count($db_settings) > 0) {
            foreach ($db_settings as $setting) {
                $this->app_settings[$setting->setting_key] = $setting->setting_value;
            }
        }
        view()->share("app_settings", $this->app_settings);
    }

    public function index()
    {
        $page_title = 'Dashboard';
        $month = date('m');
        $year = date('Y');
        $prev_month = $month == 1 ? 12 : ($month - 1);
        $prev_year = $month == 1 ? $year - 1 : $year;

        $users = User::where('user_type', '!=', 'admin')->count();
        $orders = Order::count();
        $sales_revenue = Order::sum('total_amount');
        $average_order_amount = Order::average('total_amount');
        $new_orders = Order::whereStatus('0')->with('user')->latest()->take(5)->get();
        $last_month_revenue = Order::whereMonth("created_at", $prev_month)->whereYear("created_at", $prev_year)->sum('total_amount');
        $cur_month_revenue = Order::whereMonth("created_at", $month)->whereYear("created_at", $year)->sum('total_amount');

        $chart_keys = [];
        for ($i = 0; $i < 31; $i++) {
            $chart_keys[] = $i + 1;
        }

        $previous_month = Order::selectRaw('day(created_at) as d, sum(total_amount) as amt')->whereDate('created_at', '>=', date($prev_year . '-' . $prev_month . '-01'))->whereDate('created_at', '<=', date($prev_year . '-' . $prev_month . '-t'))->groupBy(DB::raw("DAY(created_at)"))->get()->toArray();
        $current_month = Order::selectRaw('day(created_at) as d, sum(total_amount) as amt')->whereDate('created_at', '>=', date($year . '-' . $month . '-01'))->whereDate('created_at', '<=', date($year . '-' . $month . '-t'))->groupBy(DB::raw("DAY(created_at)"))->get()->toArray();

        $previous_month_keys = array_column($previous_month, 'd') ?? [];
        $current_month_keys = array_column($current_month, 'd') ?? [];

        foreach ($chart_keys as $k) {
            if (!in_array($k, $previous_month_keys)) {
                $previous_month[] = [
                    'd' => $k,
                    'amt' => 0
                ];
            }
            if (!in_array($k, $current_month_keys)) {
                $current_month[] = [
                    'd' => $k,
                    'amt' => 0
                ];
            }
        }
        array_multisort(array_column($previous_month, 'd'), SORT_ASC, $previous_month);
        array_multisort(array_column($current_month, 'd'), SORT_ASC, $current_month);

        $chart_data = [
            'previous_month' => array_column($previous_month, 'amt') ?? [],
            'current_month' => array_column($current_month, 'amt') ?? []
        ];

        if (!empty($new_orders) && count($new_orders) > 0) {
            foreach ($new_orders as $order) {
                $order->product_names = null;
                if ($order->order_type == 'subscription') {
                    $order->subscription = Subscription::whereStatus(1)->first();
                    $order->product_names = "SIPPY - " . ($order->subscription->title ?? '') . ' x1';
                } else {
                    foreach ($order->details as $detail) {
                        if (!empty($detail->product) && isset($detail->product->product_name)) {
                            $name = ($detail->product->brand->name ?? '') . ' - ' . $detail->product->product_name . ' x' . $detail->quantity;
                            $order->product_names .= (!empty($order->product_names) ? ', ' : '') . $name;
                        }
                    }
                    // if (empty($order->product_names)) {
                    foreach ($order->details as $detail) {
                        if (!empty($detail->equipment) && isset($detail->equipment->title)) {
                            $name = ($detail->equipment->brand->name ?? '') . ' - ' . $detail->equipment->title . ' x' . $detail->quantity;
                            $order->product_names .= (!empty($order->product_names) ? ', ' : '') . $name;
                        }
                    }
                    // }
                }
                if (!empty($order->product_names) && strlen($order->product_names) > 40) {
                    $order->product_names = substr($order->product_names, 0, 40) . '...';
                }
            }
        }

        $top_5_products = OrderDetail::selectRaw('sum(subtotal) as total, count(id) as order_count, product_id')
            ->whereRaw('(is_cancelled is null or is_cancelled = 0)')
            ->whereNotNull('product_id')
            ->groupBy('product_id')
            ->orderBy("total", "DESC")->limit(5)
            ->with(['product', 'product.brand'])
            ->get()->each(function ($product) {
                // $product->total = number_format($product->total, 2);
                $product->name = $product->product->product_name ?? '';
                $product->brand_name = $product->product->brand->name ?? '';
                $product->total = number_format($product->total, 2);
            });

        $top_5_equipments = OrderDetail::selectRaw('sum(subtotal) as total, count(id) as order_count, equipment_id')
            ->whereRaw('(is_cancelled is null or is_cancelled = 0)')
            ->whereNotNull('equipment_id')
            ->groupBy('equipment_id')
            ->orderBy("total", "DESC")
            ->with(['equipment', 'equipment.brand'])
            ->limit(5)->get()->each(function ($product) {
            // $product->total = number_format($product->total, 2);
            $product->name = $product->equipment->title ?? '';
            $product->brand_name = $product->equipment->brand->name ?? '';
                $product->total = number_format($product->total, 2);
            });

        $summary = [
            'users' => $users,
            'orders' => $orders,
            'sales_revenue' => $sales_revenue,
            'average_order_amount' => $average_order_amount,
            'last_month_revenue' => $last_month_revenue,
            'cur_month_revenue' => $cur_month_revenue
        ];
        return view('home', compact('summary', 'chart_keys', 'chart_data', 'new_orders', 'page_title', 'top_5_products', 'top_5_equipments'));
    }

    public function top5Summary(Request $request)
    {
        $start_date = null; // date('Y-m-d 00:00:00');
        $end_date = null; // date('Y-m-d 00:00:00');

        if ($request->type == 1) {
            $start_date = \Carbon\Carbon::today()->subDays(7)->format('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 00:00:00');
        }
        if ($request->type == 2) {
            $start_date = \Carbon\Carbon::today()->subDays(30)->format('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 00:00:00');
        }
        if ($request->type == 3) {
            $start_date = \Carbon\Carbon::now()->subMonth()->format('Y-m-01 00:00:00');
            $end_date = \Carbon\Carbon::now()->subMonth()->format('Y-m-t 00:00:00');
        }
        if ($request->type == 4) {
            $start_date = \Carbon\Carbon::now()->format('Y-m-01 00:00:00');
            $end_date = \Carbon\Carbon::now()->format('Y-m-t 00:00:00');
        }
        if ($request->type == 5) {
            $start_date = \Carbon\Carbon::now()->format('Y-01-01 00:00:00');
            $end_date = \Carbon\Carbon::now()->format('Y-12-31 00:00:00');
        }

        $top_5_products = OrderDetail::selectRaw('sum(subtotal) as total, count(id) as order_count, product_id')
            ->whereRaw('(is_cancelled is null or is_cancelled = 0)')
            ->whereNotNull('product_id')
            ->groupBy('product_id')
            ->orderBy("total", "DESC");
        if (!empty($start_date) && !empty($end_date)) {
            $top_5_products = $top_5_products->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
        }
        $top_5_products = $top_5_products->limit(5)->with('product')->get()->each(function ($product) {
            $product->name = $product->product->product_name ?? '';
            $product->brand_name = $product->product->brand()->first()->name ?? '';
            $product->total = number_format($product->total, 2);
        });

        $top_5_equipments = OrderDetail::selectRaw('sum(subtotal) as total, count(id) as order_count, equipment_id')
            ->whereRaw('(is_cancelled is null or is_cancelled = 0)')
            ->whereNotNull('equipment_id')
            ->groupBy('equipment_id')
            ->orderBy("total", "DESC");
        if (!empty($start_date) && !empty($end_date)) {
            $top_5_equipments = $top_5_equipments->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
        }
        $top_5_equipments = $top_5_equipments->limit(5)->with('equipment')->get()->each(function ($product) {
            $product->name = $product->equipment->title ?? '';
            $product->brand_name = $product->equipment->brand()->first()->name ?? '';
            $product->total = number_format($product->total, 2);
        });

        if (!empty($top_5_products) || !empty($top_5_equipments)) {
            return response()->json(['status' => true, 'products' => $top_5_products, 'equipments' => $top_5_equipments]);
        }
        return response()->json(['status' => false]);
    }

    public function dashboardSummary(Request $request)
    {
        $start_date = null; // date('Y-m-d 00:00:00');
        $end_date = null; // date('Y-m-d 00:00:00');

        if ($request->type == 1) {
            $start_date = \Carbon\Carbon::today()->subDays(7)->format('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 00:00:00');
        }
        if ($request->type == 2) {
            $start_date = \Carbon\Carbon::today()->subDays(30)->format('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 00:00:00');
        }
        if ($request->type == 3) {
            $start_date = \Carbon\Carbon::now()->format('Y-m-01 00:00:00');
            $end_date = \Carbon\Carbon::now()->format('Y-m-t 00:00:00');
        }
        if ($request->type == 4) {
            $start_date = \Carbon\Carbon::now()->subMonth()->format('Y-m-01 00:00:00');
            $end_date = \Carbon\Carbon::now()->subMonth()->format('Y-m-t 00:00:00');
        }
        if ($request->type == 5) {
            $start_date = \Carbon\Carbon::now()->format('Y-01-01 00:00:00');
            $end_date = \Carbon\Carbon::now()->format('Y-12-31 00:00:00');
        }

        $data = [];
        $total = 0;
        if ($request->data_type == 'users') {
            $data = User::where('user_type', '!=', 'admin')->selectRaw('DATE(created_at), count(*) as total')
                ->groupBy(DB::raw('DATE(created_at)'));
            if (!empty($start_date) && !empty($end_date)) {
                $data = $data->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
            }
            $data = $data->get()->pluck('total') ?? [];
            $total = array_sum($data->toArray()) ?? [];
        } else if ($request->data_type == 'orders') {
            $data = Order::selectRaw('DATE(created_at), count(*) as total')
                ->groupBy(DB::raw('DATE(created_at)'));
            if (!empty($start_date) && !empty($end_date)) {
                $data = $data->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
            }
            $data = $data->get()->pluck('total') ?? [];
            $total = array_sum($data->toArray()) ?? [];
        } else if ($request->data_type == 'sales-revenue') {
            $data = Order::selectRaw('DATE(created_at), sum(total_amount) as total')
                ->groupBy(DB::raw('DATE(created_at)'));
            if (!empty($start_date) && !empty($end_date)) {
                $data = $data->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
            }
            $data = $data->get()->pluck('total') ?? [];
            if (!empty($data)) {
                $total = $this->app_settings['currency_code'] . ' ' . number_format(array_sum($data->toArray()), 2) ?? [];
                $data = array_map(function ($num) {
                    return number_format($num, 2);
                }, $data->toArray());
            }
        } else if ($request->data_type == 'avg-sales-revenue') {
            $data = Order::selectRaw('DATE(created_at), sum(total_amount) as total')
                ->groupBy(DB::raw('DATE(created_at)'));
            if (!empty($start_date) && !empty($end_date)) {
                $data = $data->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
            }
            $data = $data->get()->pluck('total') ?? [];
            $total = array_sum($data->toArray());
            if ($total > 0) {
                $total = array_sum($data->toArray()) / Order::count();
            }
            $total = $this->app_settings['currency_code'] . ' ' . number_format($total, 2) ?? [];
            $data = array_map(function ($num) {
                return number_format($num, 2);
            }, $data->toArray());
        }

        if (!empty($data)) {
            return response()->json(['status' => true, 'data' => $data, 'total' => $total]);
        }
        return response()->json(['status' => false]);
    }
}
