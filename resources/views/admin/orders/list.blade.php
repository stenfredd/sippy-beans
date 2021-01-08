@extends('layouts.app')
@section('content')
<div class="service-requests">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-search">
                        <h4 class="card-title">
                            <b>SALES ORDERS</b><br>
                            <span class="gray">{{ $new_orders }} NEW ORDERS</span>
                        </h4>
                        <div id="ecommerce-searchbar">
                            <div class="row mt-1 justify-content-between align-items-top">
                                <div class="col-lg-9 col-md-8">

                                    <fieldset class="form-group position-relative has-icon-right mb-1 mr-0">
                                        <input type="text" class="form-control form-control-lg" id="search_order"
                                            placeholder="Search by order#, first/last name, phone number, product">
                                        <div class="form-control-position">
                                            <i class="feather icon-search px-1"></i>
                                        </div>
                                    </fieldset>

                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="d-flex justify-content-between align-items-top w-100">
                                        <button type="button"
                                            class="btn btn-orange mr-1 mb-1 waves-effect waves-light px-5 btn-lg"
                                            id="search_btn">SEARCH</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="user-profile" class="mt-1">
                    <div class="card-content service-requests-tab">
                        <div>
                            <ul class="nav nav-tabs nav-fill" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="new-orders-justified" data-toggle="tab"
                                        href="#new-orders" role="tab" aria-selected="true">NEW ORDERS
                                        ({{ $new_orders }})</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="inprogress-orders-justified" data-toggle="tab"
                                        href="#inprogress-orders" role="tab" aria-selected="false">IN PROGRESS
                                        ({{ $inprogress_orders }})</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="shipped-orders-justified" data-toggle="tab"
                                        href="#shipped-orders" role="tab" aria-selected="false">SHIPPED
                                        ({{ $shipped_orders }})</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="completed-orders-justified" data-toggle="tab"
                                        href="#completed-orders" role="tab" aria-selected="false">COMPLETED ({{ $completed_orders }})</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="cancelled-orders-justified" data-toggle="tab"
                                        href="#cancelled-orders" role="tab" aria-selected="false">CANCELLED ({{ $cancelled_orders }})</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="all-orders-justified" data-toggle="tab" href="#all-orders"
                                        role="tab" aria-selected="false">VIEW ALL ({{ $all_orders }})</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active new-orders" id="new-orders" role="tabpanel"
                                    aria-labelledby="new-orders-justified">
                                    <div class="table-responsive">
                                        <table class="service-requests-table table mb-0" id="tblNewOrders">
                                            <thead>
                                                <tr>
                                                    <th class="w-10 font-small-3 text-bold-700">ORDER NO.</th>
                                                    <th class="w-12 font-small-3 text-bold-700">CUSTOMER</th>
                                                    <th class="w-18 font-small-3 text-bold-700">ORDER</th>
                                                    <th class="w-13 font-small-3 text-bold-700">STATUS</th>
                                                    <th class="w-12 font-small-3 text-bold-700">TOTAL</th>
                                                    <th class="w-12 font-small-3 text-bold-700">PAYMENT</th>
                                                    <th class="w-12 font-small-3 text-bold-700">POINTS</th>
                                                    <th class="w-12 font-small-3 text-bold-700">ORDERED AT</th>
                                                    <th class="w-5 font-small-3 text-bold-700 no_sorting_asc"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane new-orders" id="inprogress-orders" role="tabpanel"
                                    aria-labelledby="inprogress-orders-justified">
                                    <div class="table-responsive">
                                        <table class="service-requests-table table mb-0" id="tblInprogressOrders">
                                            <thead>
                                                <tr>
                                                    <th class="w-10 font-small-3 text-bold-700">ORDER NO.</th>
                                                    <th class="w-12 font-small-3 text-bold-700">CUSTOMER</th>
                                                    <th class="w-18 font-small-3 text-bold-700">ORDER</th>
                                                    <th class="w-13 font-small-3 text-bold-700">STATUS</th>
                                                    <th class="w-12 font-small-3 text-bold-700">TOTAL</th>
                                                    <th class="w-12 font-small-3 text-bold-700">PAYMENT</th>
                                                    <th class="w-12 font-small-3 text-bold-700">POINTS</th>
                                                    <th class="w-12 font-small-3 text-bold-700">ORDERED AT</th>
                                                    <th class="w-5 font-small-3 text-bold-700 no_sorting_asc"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane new-orders" id="shipped-orders" role="tabpanel"
                                    aria-labelledby="shipped-orders-justified">
                                    <div class="table-responsive">
                                        <table class="service-requests-table table mb-0" id="tblShippedOrders">
                                            <thead>
                                                <tr>
                                                    <th class="w-10 font-small-3 text-bold-700">ORDER NO.</th>
                                                    <th class="w-12 font-small-3 text-bold-700">CUSTOMER</th>
                                                    <th class="w-18 font-small-3 text-bold-700">ORDER</th>
                                                    <th class="w-13 font-small-3 text-bold-700">STATUS</th>
                                                    <th class="w-12 font-small-3 text-bold-700">TOTAL</th>
                                                    <th class="w-12 font-small-3 text-bold-700">PAYMENT</th>
                                                    <th class="w-12 font-small-3 text-bold-700">POINTS</th>
                                                    <th class="w-12 font-small-3 text-bold-700">ORDERED AT</th>
                                                    <th class="w-5 font-small-3 text-bold-700 no_sorting_asc"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane new-orders" id="completed-orders" role="tabpanel"
                                    aria-labelledby="completed-orders-justified">
                                    <div class="table-responsive">
                                        <table class="service-requests-table table mb-0" id="tblCompletedOrders">
                                            <thead>
                                                <tr>
                                                    <th class="w-10 font-small-3 text-bold-700">ORDER NO.</th>
                                                    <th class="w-12 font-small-3 text-bold-700">CUSTOMER</th>
                                                    <th class="w-18 font-small-3 text-bold-700">ORDER</th>
                                                    <th class="w-13 font-small-3 text-bold-700">STATUS</th>
                                                    <th class="w-12 font-small-3 text-bold-700">TOTAL</th>
                                                    <th class="w-12 font-small-3 text-bold-700">PAYMENT</th>
                                                    <th class="w-12 font-small-3 text-bold-700">POINTS</th>
                                                    <th class="w-12 font-small-3 text-bold-700">ORDERED AT</th>
                                                    <th class="w-5 font-small-3 text-bold-700 no_sorting_asc"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane new-orders" id="cancelled-orders" role="tabpanel"
                                    aria-labelledby="cancelled-orders-justified">
                                    <div class="table-responsive">
                                        <table class="service-requests-table table mb-0" id="tblCancelledOrders">
                                            <thead>
                                                <tr>
                                                    <th class="w-10 font-small-3 text-bold-700">ORDER NO.</th>
                                                    <th class="w-12 font-small-3 text-bold-700">CUSTOMER</th>
                                                    <th class="w-18 font-small-3 text-bold-700">ORDER</th>
                                                    <th class="w-13 font-small-3 text-bold-700">STATUS</th>
                                                    <th class="w-12 font-small-3 text-bold-700">TOTAL</th>
                                                    <th class="w-12 font-small-3 text-bold-700">PAYMENT</th>
                                                    <th class="w-12 font-small-3 text-bold-700">POINTS</th>
                                                    <th class="w-12 font-small-3 text-bold-700">ORDERED AT</th>
                                                    <th class="w-5 font-small-3 text-bold-700 no_sorting_asc"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane new-orders" id="all-orders" role="tabpanel"
                                    aria-labelledby="all-orders-justified">
                                    <div class="table-responsive">
                                        <table class="service-requests-table table mb-0" id="tblAllOrders">
                                            <thead>
                                                <tr>
                                                    <th class="w-10 font-small-3 text-bold-700">ORDER NO.</th>
                                                    <th class="w-12 font-small-3 text-bold-700">CUSTOMER</th>
                                                    <th class="w-18 font-small-3 text-bold-700">ORDER</th>
                                                    <th class="w-13 font-small-3 text-bold-700">STATUS</th>
                                                    <th class="w-12 font-small-3 text-bold-700">TOTAL</th>
                                                    <th class="w-12 font-small-3 text-bold-700">PAYMENT</th>
                                                    <th class="w-12 font-small-3 text-bold-700">POINTS</th>
                                                    <th class="w-12 font-small-3 text-bold-700">ORDERED AT</th>
                                                    <th class="w-5 font-small-3 text-bold-700 no_sorting_asc"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
            $("#search_order").keyup(function() {
                newOrdersTable.ajax.reload();
                inprogressOrdersTable.ajax.reload();
                shippedOrdersTable.ajax.reload();
                completedOrdersTable.ajax.reload();
                cancelledOrdersTable.ajax.reload();
                allOrdersTable.ajax.reload();
            });
            $("#search_btn").click(function() {
                newOrdersTable.ajax.reload();
                inprogressOrdersTable.ajax.reload();
                shippedOrdersTable.ajax.reload();
                completedOrdersTable.ajax.reload();
                cancelledOrdersTable.ajax.reload();
                allOrdersTable.ajax.reload();
            });
        });
        let newOrdersTable = $('#tblNewOrders').DataTable({
            "processing": true,
            "serverSide": true,
			"lengthChange": false,
            "searching": false,
            "order": [],
            "ajax": {
                "url": BASE_URL + "orders",
                "type": "POST",
                "data": function(data) {
                    data._token = '{{ csrf_token() }}';
                    data.status = '0';
                    data.search = $("#search_order").val();
                }
            },
            "columns": [{
                    "data": "order_number",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "customer_name",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "product_names",
					"class": "font-small-3 text-bold-500",
                    'orderable': false,
                },
                {
                    "data": "status_text",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "total_amount",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "payment_type",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "reward_points",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "created_at",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "action",
					"class": "font-small-3 text-bold-500",
                    orderable: false
                }
            ]
        });
        let inprogressOrdersTable = $('#tblInprogressOrders').DataTable({
            "processing": true,
            "serverSide": true,
			"lengthChange": false,
            "searching": false,
            "order": [],
            "ajax": {
                "url": BASE_URL + "orders",
                "type": "POST",
                "data": function(data) {
                    data._token = '{{ csrf_token() }}';
                    data.status = '1';
                    data.search = $("#search_order").val();
                }
            },
            "columns": [{
                    "data": "order_number",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "customer_name",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "product_names",
					"class": "font-small-3 text-bold-500",
                    'orderable': false,
                },
                {
                    "data": "status_text",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "total_amount",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "payment_type",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "reward_points",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "created_at",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "action",
					"class": "font-small-3 text-bold-500",
                    orderable: false
                }
            ]
        });
        let shippedOrdersTable = $('#tblShippedOrders').DataTable({
            "processing": true,
            "serverSide": true,
			"lengthChange": false,
            "searching": false,
            "order": [],
            "ajax": {
                "url": BASE_URL + "orders",
                "type": "POST",
                "data": function(data) {
                    data._token = '{{ csrf_token() }}';
                    data.status = '2';
                    data.search = $("#search_order").val();
                }
            },
            "columns": [{
                    "data": "order_number",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "customer_name",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "product_names",
					"class": "font-small-3 text-bold-500",
                    'orderable': false,
                },
                {
                    "data": "status_text",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "total_amount",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "payment_type",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "reward_points",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "created_at",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "action",
					"class": "font-small-3 text-bold-500",
                    orderable: false
                }
            ]
        });
        let completedOrdersTable = $('#tblCompletedOrders').DataTable({
            "processing": true,
            "serverSide": true,
			"lengthChange": false,
            "searching": false,
            "order": [],
            "ajax": {
                "url": BASE_URL + "orders",
                "type": "POST",
                "data": function(data) {
                    data._token = '{{ csrf_token() }}';
                    data.status = '3';
                    data.search = $("#search_order").val();
                }
            },
            "columns": [{
                    "data": "order_number",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "customer_name",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "product_names",
					"class": "font-small-3 text-bold-500",
                    'orderable': false,
                },
                {
                    "data": "status_text",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "total_amount",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "payment_type",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "reward_points",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "created_at",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "action",
					"class": "font-small-3 text-bold-500",
                    orderable: false
                }
            ]
        });
        let cancelledOrdersTable = $('#tblCancelledOrders').DataTable({
            "processing": true,
            "serverSide": true,
			"lengthChange": false,
            "searching": false,
            "order": [],
            "ajax": {
                "url": BASE_URL + "orders",
                "type": "POST",
                "data": function(data) {
                    data._token = '{{ csrf_token() }}';
                    data.status = '4';
                    data.search = $("#search_order").val();
                }
            },
            "columns": [{
                    "data": "order_number",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "customer_name",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "product_names",
					"class": "font-small-3 text-bold-500",
                    'orderable': false,
                },
                {
                    "data": "status_text",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "total_amount",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "payment_type",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "reward_points",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "created_at",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "action",
					"class": "font-small-3 text-bold-500",
                    orderable: false
                }
            ]
        });
        let allOrdersTable = $('#tblAllOrders').DataTable({
            "processing": true,
            "serverSide": true,
			"lengthChange": false,
            "searching": false,
            "order": [],
            "ajax": {
                "url": BASE_URL + "orders",
                "type": "POST",
                "data": function(data) {
                    data._token = '{{ csrf_token() }}';
                    data.search = $("#search_order").val();
                }
            },
            "columns": [{
                    "data": "order_number",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "customer_name",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "product_names",
					"class": "font-small-3 text-bold-500",
                    'orderable': false,
                },
                {
                    "data": "status_text",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "total_amount",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "payment_type",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "reward_points",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "created_at",
					"class": "font-small-3 text-bold-500",
                },
                {
                    "data": "action",
					"class": "font-small-3 text-bold-500",
                    orderable: false
                }
            ]
        });
</script>
@endsection
