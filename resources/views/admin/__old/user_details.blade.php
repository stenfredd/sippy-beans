@extends('layouts.app') @section('content')
    <div class="content-wrapper pt-1">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Users</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('admin') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ url('admin/users') }}">Users</a>
                                </li>
                                <li class="breadcrumb-item">View User #{{ $user->id }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="horizontal-vertical">
                <div class="row">
                    <div class="col-6">
                        <div class="card p-1">
                            <div class="row">
                                <div class="col-md-8"><strong>USER INFORMATION</strong></div>
                                <div class="col-md-4 text-right"><strong>STATUS: {{ $user->status_text }}</strong></div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-inline-flex mb-2">
                                            <i class="fa fa-user-o font-size-large"></i>
                                            <span>Full Name <br> {{ $user->name }}</span>
                                        </div><br>
                                        <div class="d-inline-flex mb-2">
                                            <i class="fa fa-user-o font-size-large"></i>
                                            <span>Email Address<br> {{ $user->email }}</span>
                                        </div><br>
                                        <div class="d-inline-flex mb-2">
                                            <i class="fa fa-user-o font-size-large"></i>
                                            <span>Phone Number <br> {{ $user->phone }}</span>
                                        </div><br>
                                        <div class="d-inline-flex mb-2">
                                            <i class="fa fa-user-o font-size-large"></i>
                                            <span>Payment Gateway ID <br> {{ $user->stripe_id ?? '-' }}</span>
                                        </div><br>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-inline-flex mb-2">
                                            <i class="fa fa-user-o font-size-large"></i>
                                            <span>Password <br> ********</span>
                                        </div><br>
                                        <div class="d-inline-flex mb-2">
                                            <i class="fa fa-user-o font-size-large"></i>
                                            <span>Device <br> {{ $user->device_type == 1 ? 'Android' : 'IOS' }}</span>
                                        </div><br>
                                        <div class="d-inline-flex mb-2">
                                            <i class="fa fa-user-o font-size-large"></i>
                                            <span>Push Token<br> {{ $user->name ?? '-' }}</span>
                                        </div><br>
                                        <div class="d-inline-flex mb-2">
                                            <i class="fa fa-user-o font-size-large"></i>
                                            <span>Account Created At<br>
                                                {{ $user->created_at->format('M d, Y h:iA') }}</span>
                                        </div><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card p-1">
                            <div class="card-header">
                                <div class="card-title">Addresses</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @if (!empty($addresses) && count($addresses) > 0)
                                        @foreach ($addresses as $address)
                                            <div class="col-6">
                                                <div class="d-inline-flex mb-2">
                                                    <i class="fa fa-user-o font-size-large"></i>
                                                    <span>
                                                        {{ $address->title ?? '' }}
                                                        <br>
                                                        {{ $address->address_line_1 ?? '' }},
                                                        {{ $address->address_line_2 ?? '' }},
                                                        {{ $address->city()->first()->name ?? '' }},
                                                        {{ $address->country()->first()->country_name ?? '' }}
                                                        <br>
                                                        {{ $address->latitude ?? '' }},
                                                        {{ $address->longitude ?? '' }}
                                                    </span>
                                                </div><br>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center">
                                            <b>No address details found.</b>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Matchmaker</div>
                            </div>
                            <div class="card-body">
                                <ol>
                                    @if (!empty($match_makers) && count($match_makers) > 0)
                                        @foreach ($match_makers as $match_maker)
                                            <b>Question:</b>
                                            <br>
                                            {{ $match_maker->question }}
                                            <br>
                                            <b>Answer:</b>
                                            <br>
                                            {{ $match_maker->values_name }}
                                        @endforeach
                                    @else
                                        <div class="text-center">
                                            <b>No details found.</b>
                                        </div>
                                    @endif
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Orders</div>
                            </div>
                            <div class="card-body">
                                <table class="table nowrap w-100" id="tblOrders">
                                    <thead>
                                        <th>#ORDER NO</th>
                                        <th>CUSTOMER</th>
                                        <th>ORDER</th>
                                        <th>STATUS</th>
                                        <th>TOTAL</th>
                                        <th>PAYMENT</th>
                                        <th>POINTS</th>
                                        <th>ORDER AT</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
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
        let ordersTable = $('#tblOrders').DataTable({
            "scrollY": 500,
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "{{ url('admin/orders') }}",
                "type": "POST",
                "data": {
                    'user_id': "{{ request()->route('id') }}",
                    "_token": "{{ csrf_token() }}"
                }
            },
            "columns": [{
                    "data": "DT_RowIndex",
                    orderable: false,
                    width: '5%'
                },
                {
                    "data": "name",
                    width: '10%'
                },
                {
                    "data": "order_number",
                    width: '10%'
                },
                {
                    "data": "status_text",
                    orderable: false,
                    width: '20%'
                },
                {
                    "data": "payable_amount",
                    orderable: false,
                    width: '20%'
                },
                {
                    "data": "payable_amount",
                    orderable: false,
                    width: '20%'
                },
                {
                    "data": "reward_points",
                    orderable: false,
                    width: '20%'
                },
                {
                    "data": "created_at",
                    orderable: false,
                    width: '20%'
                },
                {
                    "data": "action",
                    orderable: false,
                    width: '10%'
                }
            ]
        });

    </script>
@endsection
