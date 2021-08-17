@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <section id="dashboard-ecommerce">

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-end">
                                <h4 class="mb-0">Order #{{ $order->order_number }} </h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body px-0 pb-0">
                                    <div id="goal-overview-chart" class="mt-75"></div>
                                    <div class="row text-center mx-0">
                                        <div class="col-4 border-top d-flex align-items-between flex-column py-1">
                                            <p class="mb-25">Order value</p>
                                            <p class=" text-bold-700">AED {{ $order->total_amount }}</p>
                                        </div>
                                        <div class="col-4 border-top d-flex align-items-between flex-column py-1">
                                            <p class="mb-25">Patment</p>
                                            <p class=" text-bold-700">******123</p>
                                        </div>
                                        <div class="col-4 border-top d-flex align-items-between flex-column py-1">
                                            <p class="mb-25">Gateway</p>
                                            <p class=" text-bold-700">Stripe</p>
                                        </div>
                                    </div>
                                    <div id="goal-overview-chart" class="mt-75"></div>
                                    <div class="row mx-0">
                                        <div class="col-12 border-top flex-column py-1">
                                            <p class="mb-25 d-flex justify-content-between align-items-end">Delivery Address
                                            </p>
                                            <p class="mt-2 mb-0 text-bold-700">
                                                {{ $order->address->address_line_1 ?? '' }},{{ $order->address->address_line_2 ?? '' }},
                                            </p>
                                            <p>{{ $order->address->city()->first()->name ?? '' }},
                                                {{ $order->address->country()->first()->country_name ?? '' }}.
                                            </p>
                                            </p>
                                        </div>
                                    </div>
                                    <div id="goal-overview-chart" class="mt-75"></div>
                                    <div class="row mx-0">
                                        <div class="col-12 border-top flex-column py-1">
                                            <div class="d-flex justify-content-between mb-25">
                                                <div class="browser-info">
                                                    <p class="mb-25">Customer</p>
                                                </div>
                                                <div class="stastics-info text-right">
                                                    <span>{{ $order->user->name ?? '-' }}</span>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between mb-25">
                                                <div class="browser-info">
                                                    <p class="mb-25">Phone</p>
                                                </div>
                                                <div class="stastics-info text-right">
                                                    <span>{{ $order->user->phone ?? '-' }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between mb-25">
                                                <div class="browser-info">
                                                    <p class="mb-25">Email Address</p>
                                                </div>
                                                <div class="stastics-info text-right">
                                                    <span>{{ $order->user->email ?? '-' }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between mb-25">
                                                <div class="browser-info">
                                                    <p class="mb-25">Ordered At</p>
                                                </div>
                                                <div class="stastics-info text-right">
                                                    <span>{{ $order->created_at->format('M d, Y h:iA') ?? '-' }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between mb-25">
                                                <div class="browser-info">
                                                    <p class="mb-25">Ordered Via</p>
                                                </div>
                                                <div class="stastics-info text-right">
                                                    <span> - </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-end">
                                <h4 class="card-title">Order Details</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body pb-0">
                                    <div class="d-flex justify-content-start">
                                        <div class="table-responsive">

                                            <table class="table nowrap w-100" id="tblDetails">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Seller</th>
                                                        <th>Rate</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($order->details as $item)
                                                        <tr>
                                                            <td>{{ $item->product->product_name ?? '' }}</td>
                                                            <td>{{ $item->product->seller->seller_name ?? '' }}</td>
                                                            <td>{{ $item->product->price ?? '' }}</td>
                                                            <td>{{ $item->quantity ?? '' }}</td>
                                                            <td>{{ $item->subtotal ?? '' }}</td>
                                                            <td>{{ $item->id ?? '' }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center">No record found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-inline-flex mb-2">
                                            <i class="fa fa-user-o font-size-large"></i>
                                            <span>Reward Points <br> {{ $order->reward_points }}</span>
                                        </div><br>
                                        <div class="d-inline-flex mb-2">
                                            <i class="fa fa-user-o font-size-large"></i>
                                            <span>Status <br> {{ $order->status_text }}</span>
                                        </div><br>
                                        <div class="d-inline-flex mb-2">
                                            <i class="fa fa-user-o font-size-large"></i>
                                            <span>Payment Status<br> {{ $order->status_text }}</span>
                                        </div><br>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-25">
                                            <div class="browser-info">
                                                <p class="mb-25">Subtotal:</p>
                                            </div>
                                            <div class="stastics-info text-right">
                                                <span>{{ $order->subtotal ?? '-' }}</span>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between mb-25">
                                            <div class="browser-info">
                                                <p class="mb-25">Delivery Fee</p>
                                            </div>
                                            <div class="stastics-info text-right">
                                                <span>{{ $order->delivery_fee ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mb-25">
                                            <div class="browser-info">
                                                <p class="mb-25">Discount</p>
                                            </div>
                                            <div class="stastics-info text-right">
                                                <span>{{ $order->discount_amount ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between mb-25">
                                            <div class="browser-info">
                                                <p class="mb-25">Subtotal:</p>
                                            </div>
                                            <div class="stastics-info text-right">
                                                <span>{{ (($order->subtotal + $order->delivery_fee) - $order->discount_amount) ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mb-25">
                                            <div class="browser-info">
                                                <p class="mb-25">Tax Charges</p>
                                            </div>
                                            <div class="stastics-info text-right">
                                                <span>{{ $order->tax_charges ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="d-flex justify-content-between mb-25">
                                            <div class="browser-info">
                                                <p class="mb-25">Payable Amount</p>
                                            </div>
                                            <div class="stastics-info text-right">
                                                <span>{{ $order->payable_amount ?? '-' }}</span>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between mb-25">
                                            <div class="browser-info">
                                                <p class="mb-25">Paid Amount</p>
                                            </div>
                                            <div class="stastics-info text-right">
                                                <span>{{ $order->paid_amount ?? '-' }}</span>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between mb-25">
                                            <div class="browser-info">
                                                <p class="mb-25">Balance</p>
                                            </div>
                                            <div class="stastics-info text-right">
                                                <span>{{ ($order->payable_amount - $order->paid_amount) ?? '-' }}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-end">
                                <h4 class="card-title">
                                    <div class="row">
                                        <div class="col-7">
                                            <span>Transactions</span>
                                        </div>
                                        <div class="col-5">
                                            <button class="float-right btn btn-info btn-sm">Add Transaction</button>
                                        </div>
                                    </div>
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body pb-0">
                                    <div class="d-flex justify-content-start">
                                        <div class="table-responsive">

                                            <table class="table nowrap w-100" id="tblTransactions">
                                                <thead>
                                                    <tr>
                                                        <th>Payment ID</th>
                                                        <th>Type</th>
                                                        <th>Amount</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($order->transactions as $transaction)
                                                        <tr>
                                                            <td>{{ $transaction->payment_id ?? '' }}</td>
                                                            <td>{{ ucfirst($transaction->type) ?? '' }}</td>
                                                            <td>{{ $transaction->amount ?? '' }}</td>
                                                            <td>{{ $transaction->created_at->format('M d,Y h:iA') ?? '' }}</td>
                                                            <td>{{ $transaction->subtotal ?? '' }}</td>
                                                            <td>{{ $transaction->id ?? '' }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center">No record found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-end">
                                <h4 class="card-title">Activity Log</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body pb-0">
                                    <div class="d-flex justify-content-start">
                                        <div class="table-responsive">

                                            <table class="table nowrap w-100" id="tblTransactions">
                                                <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Message</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($order->activities as $activity)
                                                        <tr>
                                                            <td>{{ ucfirst($activity->type) ?? '' }}</td>
                                                            <td>{{ $activity->message ?? '' }}</td>
                                                            <td>{{ $activity->created_at->format('M d,Y h:iA') ?? '' }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center">No record found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Notes</div>
                            </div>
                            <div class="card-body">
                                <p><b>Customer Note:</b><br>{{ $order->customer_note ?? '-' }}</p>
                                {{-- <p>Internal Note:<br>{{ $order->internal_note ?? '-' }}
                                </p> --}}
                                <div class="form-actions"></div>
                                <div class="form-group">
                                    <label for="internal_note" class="control-label"><strong>Internal Note:</strong></label>
                                    <textarea class="form-control" name="internal_note" id="internal_note" cols="30"
                                        rows="10">{{ $order->internal_note ?? '-' }}</textarea>
                                </div>
                                <div class="form-actions">
                                    <button id="save-internal-note" type="button" class="btn btn-success"
                                        onclick="updateNote();">Save</button>
                                </div>
                            </div>
                        </div>



                    </div>

                </div>
        </div>
        </section>
    </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function updateNote() {
            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('order_id', '{{ $order->id ?? 0 }}');
            formData.append('internal_note', $("#internal_note").val());
            $.ajax({
                url: "{{ url('admin/orders/update') }}",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === true) {
                        toastr.success(response.message, 'Success', {
                            "closeButton": true,
                            "progressBar": true,
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            "timeOut": 2000
                        });
                    } else {
                        toastr.error(response.message, 'Error', {
                            "closeButton": true,
                            "progressBar": true,
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            "timeOut": 2000
                        });
                    }
                }
            });
        }

    </script>
@endsection
