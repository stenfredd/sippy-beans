{{-- @extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-body">
        <section id="dashboard-ecommerce">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column align-items-start pb-0">
                            <div class="avatar bg-rgba-primary p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-users text-primary font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1">{{ $summary['users'] ?? 0 }}</h2>
<p class="mb-0">Registered users</p>
</div>
<div class="card-content">
    <div id="line-area-chart-1"></div>
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-12">
    <div class="card">
        <div class="card-header d-flex flex-column align-items-start pb-0">
            <div class="avatar bg-rgba-success p-50 m-0">
                <div class="avatar-content">
                    <i class="feather icon-credit-card text-success font-medium-5"></i>
                </div>
            </div>
            <h2 class="text-bold-700 mt-1">{{ $summary['orders'] ?? 0 }}</h2>
            <p class="mb-0">Total Orders</p>
        </div>
        <div class="card-content">
            <div id="line-area-chart-2"></div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-sm-6 col-12">
    <div class="card">
        <div class="card-header d-flex flex-column align-items-start pb-0">
            <div class="avatar bg-rgba-danger p-50 m-0">
                <div class="avatar-content">
                    <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                </div>
            </div>
            <h2 class="text-bold-700 mt-1">{{ $summary['sales_revenue'] ?? 0 }}</h2>
            <p class="mb-0">Sales Revenue</p>
        </div>
        <div class="card-content">
            <div id="line-area-chart-3"></div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-sm-6 col-12">
    <div class="card">
        <div class="card-header d-flex flex-column align-items-start pb-0">
            <div class="avatar bg-rgba-warning p-50 m-0">
                <div class="avatar-content">
                    <i class="feather icon-package text-warning font-medium-5"></i>
                </div>
            </div>
            <h2 class="text-bold-700 mt-1">{{ $summary['average_order_amount'] ?? 0 }}</h2>
            <p class="mb-0">Average Basket Value</p>
        </div>
        <div class="card-content">
            <div id="line-area-chart-4"></div>
        </div>
    </div>
</div>
</div>
<div class="row">
    <div class="col-lg-8 col-md-6 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-end">
                <h4 class="card-title">SALES REVENUE</h4>
                <p class="font-medium-5 mb-0"><i class="feather icon-settings text-muted cursor-pointer"></i></p>
            </div>
            <div class="card-content">
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-start">
                        <div class="mr-2">
                            <p class="mb-50 text-bold-600">This Month</p>
                            <h2 class="text-bold-400">
                                <span class="text-success">{{ $app_settings['currency_code'] }}
                                    86,589</span>
                            </h2>
                        </div>
                        <div>
                            <p class="mb-50 text-bold-600">Last Month</p>
                            <h2 class="text-bold-400">
                                <span>{{ $app_settings['currency_code'] }} 73,683</span>
                            </h2>
                        </div>
                    </div>
                    <div id="revenue-chart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-end">
                <h4 class="mb-0">TOP SELLING ITEMS </h4>
                <p class="font-medium-5 mb-0"><i class="feather icon-help-circle text-muted cursor-pointer"></i></p>
            </div>
            <div class="card-content">
                <div class="card-body px-0 pb-0">
                    <div id="goal-overview-chart" class="mt-75"></div>
                    <div class="row text-center mx-0">
                        <div class="col-6 border-top border-right d-flex align-items-between flex-column py-1">
                            <p class="mb-50">Completed</p>
                            <p class="font-large-1 text-bold-700">786,617</p>
                        </div>
                        <div class="col-6 border-top d-flex align-items-between flex-column py-1">
                            <p class="mb-50">In Progress</p>
                            <p class="font-large-1 text-bold-700">13,561</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Sales Orders - New Orders</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <table class="table table-hovered">
                        <thead>
                            <th>Order Number</th>
                            <th>Status</th>
                            <th>Customer</th>
                            <th>Order</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Date</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @if (!empty($new_orders) && count($new_orders) > 0)
                            @foreach ($new_orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->status_text }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->total_amount }}</td>
                                <td>{{ $order->total_amount }}</td>
                                <td>{{ $order->created_at->format('M d, g:mA') }}</td>
                                <td>View</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="8">No new orders found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</div>
</div>
@endsection --}}



@extends('layouts.app')
@section('content')
<section id="dashboard-analytics">
    <div class="row dashboard-analytics-top">
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card overflow-v">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="avatar bg-rgba-primary p-50 m-0">

                            <div class="avatar-content">
                                <i class="feather icon-users text-blue font-medium-5"></i>
                            </div>
                        </div>
                        <div class="dropdown chart-dropdown">
                            <div class="dropdown chart-dropdown">
                                <select class="ui dropdown top right pointing" onchange="dashboardFilter('users')" id="users-filter">
                                    <option value="0">All</option>
                                    <option value="1">Last 7 Days</option>
                                    <option value="2">Last 30 Days</option>
                                    <option value="3">This Month</option>
                                    <option value="4">Last Month</option>
                                    <option value="5">This Year</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <h2 class="text-bold-700 mt-1 mb-25" id="users_total">{{ $summary['users'] ?? 0 }}</h2>
                    <p class="mb-0 text-bold-500">Registered Users</p>
                </div>
                <div class="card-content">
                    <div id="users-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card overflow-v">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-file-text text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <div class="dropdown chart-dropdown">
                            <div class="dropdown chart-dropdown">
                                <select class="ui dropdown top right pointing" onchange="dashboardFilter('orders')" id="orders-filter">
                                    <option value="0">All</option>
                                    <option value="1">Last 7 Days</option>
                                    <option value="2">Last 30 Days</option>
                                    <option value="3">This Month</option>
                                    <option value="4">Last Month</option>
                                    <option value="5">This Year</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1 mb-25" id="orders_total">{{ $summary['orders'] ?? 0 }}</h2>
                    <p class="mb-0 text-bold-500">Sales Orders</p>
                </div>
                <div class="card-content">
                    <div id="orders-received-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card overflow-v">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="avatar bg-rgba-success p-50 m-0">
                            <div class="avatar-content">
                                <i class="fontawesome fa fa-usd text-success font-medium-5"></i>
                            </div>
                        </div>
                        <div class="dropdown chart-dropdown">
                            <div class="dropdown chart-dropdown">
                                <select class="ui dropdown top right pointing" onchange="dashboardFilter('sales-revenue')" id="sales-revenue-filter">
                                    <option value="0">All</option>
                                    <option value="1">Last 7 Days</option>
                                    <option value="2">Last 30 Days</option>
                                    <option value="3">This Month</option>
                                    <option value="4">Last Month</option>
                                    <option value="5">This Year</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1 mb-25" id="sales_revenue_total">{{ $app_settings['currency_code'] .' '. number_format($summary['sales_revenue'],2) ?? 0 }}</h2>
                    <p class="mb-0 text-bold-500">Sales Revenue</p>
                </div>
                <div class="card-content">
                    <div id="sales-revenue-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card overflow-v">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="avatar bg-rgba-danger p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <div class="dropdown chart-dropdown">
                            <div class="dropdown chart-dropdown">
                                <select class="ui dropdown top right pointing" onchange="dashboardFilter('avg-sales-revenue')" id="avg-sales-revenue-filter">
                                    <option value="0">All</option>
                                    <option value="1">Last 7 Days</option>
                                    <option value="2">Last 30 Days</option>
                                    <option value="3">This Month</option>
                                    <option value="4">Last Month</option>
                                    <option value="5">This Year</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1 mb-25" id="avg_sales_revenue_total">{{ $app_settings['currency_code'] .' '. number_format($summary['average_order_amount'],2) ?? 0 }}
                    </h2>
                    <p class="mb-0 text-bold-500">Average Cart Value</p>
                </div>
                <div class="card-content">
                    <div id="average-service-value-chart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 col-md-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-end">
                    <h4 class="text-bold-700 card-title">SALES REVENUE</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-start">
                            <div class="mr-2">
                                <p class="mb-50 text-bold-600">This Month</p>
                                <h2 class="text-bold-400">
                                    <span class="text-success">{{ $app_settings['currency_code'] }}</span>
                                    <span class="text-success text-bold-700">{{
                                        number_format($summary['cur_month_revenue'],2) }}</span>
                                </h2>
                            </div>
                            <div>
                                <p class="mb-50 text-bold-600">Last Month</p>
                                <h2 class="text-bold-400">
                                    <span>{{ $app_settings['currency_code'] }}</span>
                                    <span class="text-bold-700">{{ number_format($summary['last_month_revenue'],2)
                                        }}</span>
                                </h2>
                            </div>

                        </div>
                        <div id="revenue-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-bold-700 card-title w-60">TOP SELLING ITEMS</h4>
                    <div class="dropdown chart-dropdown">
                        <select class="ui dropdown top right pointing" id="pro_equip_filter"
                            onchange="top5Summary(this)">
                            <option value="0">All</option>
                            <option value="1">Last 7 Days</option>
                            <option value="2">Last 30 Days</option>
                            <option value="3">This Month</option>
                            <option value="4">Last Month</option>
                            <option value="5">This Year</option>
                        </select>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body pb-50">
                        <div class="form-group mb-50">
                            {{-- <div class="ui fluid search selection dropdown"> --}}
                            {{-- <input type="hidden" name="country">
                                <i class="dropdown icon"></i>
                                <div class="default text text-dark">Products: Beans</div>
                                <div class="menu">
                                    <div class="item" data-value="Products Beans">Products: Beans</div>
                                    <div class="item" data-value="Products Beans">Products Beans</div>
                                    <div class="item" data-value="Products Beans">Products Beans</div>
                                </div> --}}
                            <select name="top_5_summary_filter" id="top_5_summary_filter" class="form-control">
                                <option value="product">Products: Beans</option>
                                <option value="equipment">Products: Equipments</option>
                            </select>
                            {{--
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-content">
                        <div id="top_5_products" class="top_filter">
                            <div class="table-responsive mt-0">
                                <table class="table table-borderless mb-0" id="top5SummaryCardProducts">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom"></th>
                                            <th class="border-bottom font-small-3 text-bold-700">PRODUCT</th>
                                            <th class="border-bottom font-small-3 text-bold-700">ORDERS</th>
                                            <th class="border-bottom font-small-3 text-bold-700">REVENUE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($top_5_products as $k => $item)
                                        <tr>
                                            <td>{{ $k + 1 }}</td>
                                            <td class="font-small-3 text-bold-700">
{{ $item->name ?? ($item->product->product_name ?? '-') }}<span
                                                    class="d-block gray text-bold-500">{{ $item->product->brand->name
                                                    ?? '-' }}</span>
                                            </td>
                                            <td class="font-small-3 text-bold-700">{{ $item->order_count }}</td>
                                            <td class="font-small-3 text-bold-500">{{ $app_settings['currency_code'] }}
                                                <span class="text-bold-700">{{ $item->total }} </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        {{--
                                        <tr>
                                            <td>2</td>
                                            <td class="font-small-3 text-bold-700">Basques de San F…<span
                                                    class="d-block gray text-bold-500">Fritz Coffee</span></td>
                                            <td class="font-small-3 text-bold-700">50</td>
                                            <td class="font-small-3 text-bold-500">{{ $app_settings['currency_code'] }}
                                        <span class="text-bold-700">2,500.00</span>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td class="font-small-3 text-bold-700">Basques de San F…<span
                                                    class="d-block gray text-bold-500">Fritz Coffee</span></td>
                                            <td class="font-small-3 text-bold-700">50</td>
                                            <td class="font-small-3 text-bold-500">{{ $app_settings['currency_code'] }}
                                                <span class="text-bold-700">2,500.00</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td class="font-small-3 text-bold-700">Basques de San F…<span
                                                    class="d-block gray text-bold-500">Fritz Coffee</span></td>
                                            <td class="font-small-3 text-bold-700">50</td>
                                            <td class="font-small-3 text-bold-500">{{ $app_settings['currency_code'] }}
                                                <span class="text-bold-700">2,500.00</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td class="font-small-3 text-bold-700">Basques de San F…<span
                                                    class="d-block gray text-bold-500">Fritz Coffee</span></td>
                                            <td class="font-small-3 text-bold-700">50</td>
                                            <td class="font-small-3 text-bold-500">{{ $app_settings['currency_code'] }}
                                                <span class="text-bold-700">2,500.00</span>
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="top_5_equipments" class="top_filter" style="display: none;">
                            <div class="table-responsive mt-0">
                                <table class="table table-borderless mb-0" id="top5SummaryCardEquipments">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom"></th>
                                            <th class="border-bottom font-small-3 text-bold-700">EQUIPMENT</th>
                                            <th class="border-bottom font-small-3 text-bold-700">ORDERS</th>
                                            <th class="border-bottom font-small-3 text-bold-700">REVENUE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($top_5_equipments as $k => $item)
                                        <tr>
                                            <td>{{ $k + 1 }}</td>
                                            <td class="font-small-3 text-bold-700">
{{ $item->name ?? ($item->equipment->title ?? '-') }}<span
                                                    class="d-block gray text-bold-500">{{ $item->equipment->brand->name
                                                    ?? '-' }}</span>
                                            </td>
                                            <td class="font-small-3 text-bold-700">{{ $item->order_count }}</td>
                                            <td class="font-small-3 text-bold-500">{{ $app_settings['currency_code'] }}
                                                <span class="text-bold-700">{{ $item->total }} </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{-- <div class="row"> --}}
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h4 class="mb-0 text-bold-700 card-title">SALES ORDERS - NEW ORDERS</h4>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<a href='{{ url('admin/orders') }}'
                            class="float-right btn btn-primary font-weight-bold btn-lg waves-effect waves-light px-1">VIEW
                            ALL - NEW ORDERS</a>
                    </div>
                    {{--
                    </div> --}}
                </div>
                <div class="card-content">
                    <div class="table-responsive mt-1">
                        <table class="service-requests-table table table-hover-animation mb-0">
                            <thead>
                                <tr>
                                    <th class="w-12 font-small-3 text-bold-700">ORDER NO.</th>
                                    <th class="w-13 font-small-3 text-bold-700">STATUS</th>
                                    <th class="w-15 font-small-3 text-bold-700">CUSTOMER</th>
                                    <th class="w-22 font-small-3 text-bold-700">ORDER</th>
                                    <th class="w-12 font-small-3 text-bold-700">TOTAL</th>
                                    <th class="w-12 font-small-3 text-bold-700">PAYMENT</th>
                                    <th class="w-12 font-small-3 text-bold-700">DATE</th>
                                    <th class="w-5 font-small-3 text-bold-700"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($new_orders as $order)
                                <tr>
                                    <td class="font-small-3 text-bold-500">#{{ $order->order_number }}</td>
                                    <td class="font-small-3 text-bold-500">
                                        <div class="d-flex status-options">
                                            <div class="d-inline-block selected mr-25">
                                                <div class="color-option border-lighgreen">
                                                    <div class="filloption bg-lighgreen"></div>
                                                </div>
                                            </div>
                                            <span class="text-lighgreen">New Order</span>
                                        </div>
                                    </td>
                                    <td class="font-small-3 text-bold-500">{{ $order->user->name }}</td>
                                    <td class="font-small-3 text-bold-500">
                                        {{ $order->product_names ?? '-' }}
                                    </td>
                                    <td class="font-small-3 text-bold-500">{{ $app_settings['currency_code'] }}
                                        {{ number_format($order->total_amount,2) }}</td>
                                    <td class="font-small-3 text-bold-500">
                                        <div class="d-flex align-items-center">
                                            @if(strtolower($order->payment_type) == 'card')
<img src="{{ asset('assets/images/'.$order->card_type.'.png') }}" height="7px">
                                            <span>
                                                **** {{ ucfirst($order->card_number) }}
                                            </span>
                                            @else
                                            <span>
                                                Cash On Delivery
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="font-small-3 text-bold-500">
                                        {{ $order->created_at->timezone($app_settings['timezone'])->format("M d, g:iA")
                                        }}
                                    </td>
                                    <td class="font-small-3 text-bold-500"><a
                                            href="{{ url('admin/orders/'.$order->id) }}"><i
                                                class="feather icon-eye"></i></a></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        No order details found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Dashboard Analytics end -->
@endsection

@section('scripts')
<script type="text/javascript">
    let usersChartoptions;
    let usersChart;
    let orderChartoptions;
    let orderChart;
    let salesRevenueChartOptions;
    let salesRevenueChart;
    let avgsalesRevenueChartOptions;
    let avgsalesRevenueChart;

    $(document).ready(function () {
        $("#top_5_summary_filter").change(function () {
            $('.top_filter').hide();
            $('#top_5_' + $(this).val() + 's').show();
        });
        dashboardFilter('users');
        dashboardFilter('orders');
        dashboardFilter('sales-revenue');
        dashboardFilter('avg-sales-revenue');

        usersChartoptions = {
            chart: {
                height: 100,
                type: 'area',
                toolbar: {
                    show: false,
                },
                sparkline: {
                    enabled: true
                },
                grid: {
                    show: false,
                    padding: {
                        left: 0,
                        right: 0
                    }
                },
            },
            colors: [$primary],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2.5
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 0.9,
                    opacityFrom: 0.7,
                    opacityTo: 0.5,
                    stops: [0, 80, 100]
                }
            },
            series: [{
                name: 'Users',
                data: [0]
            }],

            xaxis: {
                labels: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                }
            },
            yaxis: [{
                y: 0,
                offsetX: 0,
                offsetY: 0,
                padding: { left: 0, right: 0 },
            }],
            tooltip: {
                x: { show: false }
            },
        };
        usersChart = new ApexCharts(
            document.querySelector("#users-chart"),
            usersChartoptions
        );
        usersChart.render();

        orderChartoptions = {
            chart: {
                height: 100,
                type: 'area',
                toolbar: {
                    show: false,
                },
                sparkline: {
                    enabled: true
                },
                grid: {
                    show: false,
                    padding: {
                        left: 0,
                        right: 0
                    }
                },
            },
            colors: [$warning],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2.5
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 0.9,
                    opacityFrom: 0.7,
                    opacityTo: 0.5,
                    stops: [0, 80, 100]
                }
            },
            series: [{
                name: 'Orders',
                data: [0]
            }],

            xaxis: {
                labels: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                }
            },
            yaxis: [{
                y: 0,
                offsetX: 0,
                offsetY: 0,
                padding: { left: 0, right: 0 },
            }],
            tooltip: {
                x: { show: false }
            },
        }
        orderChart = new ApexCharts(
            document.querySelector("#orders-received-chart"),
            orderChartoptions
        );
        orderChart.render();

        salesRevenueChartOptions = {
            chart: {
                height: 100,
                type: 'area',
                toolbar: {
                    show: false,
                },
                sparkline: {
                    enabled: true
                },
                grid: {
                    show: false,
                    padding: {
                        left: 0,
                        right: 0
                    }
                },
            },
            colors: [$green],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2.5
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 0.9,
                    opacityFrom: 0.7,
                    opacityTo: 0.5,
                    stops: [0, 80, 100]
                }
            },
            series: [{
                name: 'Sales Revenue',
                data: [0]
            }],

            xaxis: {
                labels: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                }
            },
            yaxis: [{
                y: 0,
                offsetX: 0,
                offsetY: 0,
                padding: { left: 0, right: 0 },
            }],
            tooltip: {
                x: { show: false }
            },
        }
        salesRevenueChart = new ApexCharts(
            document.querySelector("#sales-revenue-chart"),
            salesRevenueChartOptions
        );
        salesRevenueChart.render();

        avgsalesRevenueChartOptions = {
            chart: {
                height: 100,
                type: 'area',
                toolbar: {
                    show: false,
                },
                sparkline: {
                    enabled: true
                },
                grid: {
                    show: false,
                    padding: {
                        left: 0,
                        right: 0
                    }
                },
            },
            colors: [$pink],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2.5
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 0.9,
                    opacityFrom: 0.7,
                    opacityTo: 0.5,
                    stops: [0, 80, 100]
                }
            },
            series: [{
                name: 'Avg. Sales Revenue',
                data: [0]
            }],

            xaxis: {
                labels: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                }
            },
            yaxis: [{
                y: 0,
                offsetX: 0,
                offsetY: 0,
                padding: { left: 0, right: 0 },
            }],
            tooltip: {
                x: { show: false }
            },
        }
        avgsalesRevenueChart = new ApexCharts(
            document.querySelector("#average-service-value-chart"),
            avgsalesRevenueChartOptions
        );
        avgsalesRevenueChart.render();

        var revenueChartoptions = {
            chart: {
                height: 270,
                toolbar: {
                    show: false
                },
                type: 'line',
            },
            stroke: {
                curve: 'smooth',
                dashArray: [0, 8],
                width: [4, 2],
            },
            grid: {
                borderColor: $label_color,
            },
            legend: {
                show: false,
            },
            colors: [$danger_light, $strok_color],

            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    inverseColors: false,
                    gradientToColors: [$primary, $strok_color],
                    shadeIntensity: 1,
                    type: 'horizontal',
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100, 100, 100]
                },
            },
            markers: {
                size: 0,
                hover: {
                    size: 5
                }
            },
            xaxis: {
                labels: {
                    style: {
                        colors: $strok_color,
                    }
                },
                axisTicks: {
                    show: true,
                },
                categories: JSON.parse("@json($chart_keys)"),
                axisBorder: {
                    show: false,
                },
                tickPlacement: 'on',
            },
            yaxis: {
                tickAmount: 5,
                labels: {
                    style: {
                        color: $strok_color,
                    },
                    formatter: function (val) {
                        return val > 999 ? (val / 1000).toFixed(1) + 'k' : val;
                    }
                }
            },
            tooltip: {
                x: {
                    show: false
                }
            },
            series: [{
                name: "This Month",
                data: JSON.parse('@json($chart_data["current_month"])')
            },
            {
                name: "Last Month",
                data: JSON.parse('@json($chart_data["previous_month"])')
            }
            ],
        };
        var revenueChart = new ApexCharts(
            document.querySelector("#revenue-chart"),
            revenueChartoptions
        );
        revenueChart.render();
    });

    function top5Summary(t) {
        let type = $("#pro_equip_filter").val();

        $.ajax({
            url: BASE_URL + 'top-5-summary',
            type: "post",
            data: {
                _token: '{{ csrf_token() }}',
                type: type
            },
            success: function (response) {
                $("#top5SummaryCardProducts tbody").html('');
                $("#top5SummaryCardEquipments tbody").html('');

                if (response.status === true) {
                    $.each(response.products, function (index, product) {
                        let html = '<tr>\
                                <td>'+ (parseInt(index) + 1) + '</td>\
                                <td class="font-small-3 text-bold-700">\
                                    '+ product.name + '<span class="d-block gray text-bold-500">' + product.brand_name + '</span>\
                                </td>\
                                <td class="font-small-3 text-bold-700">'+product.order_count+'</td>\
                                <td class="font-small-3 text-bold-500">\
                                    {{ $app_settings["currency_code"] }}\
                                    <span class="text-bold-700">'+ product.total + '</span>\
                                </td>\
                            </tr>';
                        $("#top5SummaryCardProducts tbody").append(html);
                    });
                    $.each(response.equipments, function (index, equipment) {
                        let html = '<tr>\
                                <td>'+ (parseInt(index) + 1) + '</td>\
                                <td class="font-small-3 text-bold-700">\
                                    '+ equipment.name + '<span class="d-block gray text-bold-500">' + equipment.brand_name + '</span>\
                                </td>\
                                <td class="font-small-3 text-bold-700">'+equipment.order_count+'</td>\
                                <td class="font-small-3 text-bold-500">\
                                    {{ $app_settings["currency_code"] }}\
                                    <span class="text-bold-700">'+ equipment.total + '</span>\
                                </td>\
                            </tr>';
                        $("#top5SummaryCardEquipments tbody").append(html);
                    });
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    }

    function dashboardFilter(type) {
        let data_type = type;
        let type_value = $("#" + type + '-filter').val();

        $.ajax({
            url: BASE_URL + 'dashboard-summary',
            type: "post",
            data: {
                _token: '{{ csrf_token() }}',
                type: type_value,
                data_type: data_type,
            },
            success: function (response) {
                if (response.status === true) {
                    if(type == 'users') {
                        // usersChartoptions.series[0].data = response.data;
                        usersChart.updateSeries([{
                            data: response.data
                        }]);
                        $("#users_total").html(response.total);
                    }
                    else if(type == 'orders') {
                        orderChart.updateSeries([{
                            data: response.data
                        }]);
                        $("#orders_total").html(response.total);
                    }
                    else if(type == 'sales-revenue') {
                        salesRevenueChart.updateSeries([{
                            data: response.data
                        }]);
                        $("#sales_revenue_total").html(response.total);
                    }
                    else if(type == 'avg-sales-revenue') {
                        avgsalesRevenueChart.updateSeries([{
                            data: response.data
                        }]);
                        $("#avg_sales_revenue_total").html(response.total);
                    }
                }
            },
            error: function (err) {
                console.log(err);
            }
        });

    }

</script>
@endsection
