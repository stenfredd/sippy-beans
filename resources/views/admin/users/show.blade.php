@extends('layouts.app')
@section('content')
<div id="user-profile">
    <div class="user-profile mb-2">
        <div class="row">
            <div class="col-12">
                <div class="profile-header">
                    <div class="relative">
                        <div class="cover-container">
                            <img class="img-fluid bg-cover rounded-0 w-100" src="{{ asset('assets/images/bitmap.png')}}"
                                alt="User Profile Image">
                        </div>
                        <div class="profile-img-container d-flex align-items-center justify-content-left">
                            <div class="profile-img-div">
<img src="{{ $user->profile_image ?? asset('assets/images/userProfile.png')}}" class="img-responsive"
                                    alt="Card image" style="height: 100%;">
                            </div>
                            <h2>{{ $user->name }}</h2>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center profile-header-nav">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                    aria-controls="home" role="tab" aria-selected="true">USER PROFILE</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                                    aria-controls="profile" role="tab" aria-selected="false">REWARD POINTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders"
                                    aria-controls="orders" role="tab" aria-selected="false">ORDERS</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane  active" id="home" aria-labelledby="home-tab" role="tabpanel">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-1">
                            <div>
                                <p class="mb-75"><strong>USER INFORMATION </strong></p>
                            </div>
                            <p>
                                <strong>STATUS:
                                    {{-- @if ($user->status == 1)
                                    <span class="success">ACTIVE</span>
                                    @else
                                    <span class="danger">INACTIVE</span>
                                    @endif --}}
                                </strong>
                                <select class="form-control-sm" id="user_status" onchange="saveUser('status')">
                                    <option value="1" {{ ($user->status == 1 ? 'selected' : '') }}>Active</option>
                                    <option value="2" {{ ($user->status == 2 ? 'selected' : '') }}>Inactive</option>
                                </select>
                                <button class="btn btn-warning btn-sm p-1" title="Edit User" data-toggle="modal" data-target="#edit-user">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </p>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 col-md-12 col-sm-12">
                                        <div class="d-flex justify-content-start align-items-center mb-1">
                                            <div class="avatar mr-1">
                                                <img src="{{ asset('assets/images/full-name.png')}}"
                                                    alt="avtar img holder" height="45" width="45">
                                            </div>
                                            <div class="user-page-info">
                                                <p class="mb-0 gray font-small-4">Full Name</p>
                                                <span class="font-small-3">{{ $user->name }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-start align-items-center mb-1">
                                            <div class="avatar mr-1">
                                                <img src="{{ asset('assets/images/email-address.png')}}"
                                                    alt="avtar img holder" height="45" width="45">
                                            </div>
                                            <div class="user-page-info">
                                                <p class="mb-0 gray font-small-4">Email Address</p>
                                                <span class="font-small-3">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-start align-items-center mb-1">
                                            <div class="avatar mr-1">
                                                <img src="{{ asset('assets/images/phone-number.png')}}"
                                                    alt="avtar img holder" height="45" width="45">
                                            </div>
                                            <div class="user-page-info">
                                                <p class="mb-0 gray font-small-4">Phone Number</p>
                                                <span
                                                    class="font-small-3">{{ $user->country_code .' ' . $user->phone  }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-start align-items-center mb-1">
                                            <div class="avatar mr-1">
                                                <img src="{{ asset('assets/images/payment-gateway-id.png')}}"
                                                    alt="avtar img holder" height="45" width="45">
                                            </div>
                                            <div class="user-page-info">
                                                <p class="mb-0 gray font-small-4">Payment Gateway ID</p>
                                                <span class="font-small-3">{{ $user->stripe_id }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-12 col-sm-12">
                                        <div class="d-flex justify-content-start align-items-center mb-1">
                                            <div class="avatar mr-1">
                                                <img src="{{ asset('assets/images/password.png')}}"
                                                    alt="avtar img holder" height="45" width="45">
                                            </div>
                                            <div class="user-page-info">
                                                <p class="mb-0 gray font-small-4">Password</p>
                                                <span class="font-small-3">* * * * * * * * *</span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-start align-items-center mb-1">
                                            <div class="avatar mr-1">
                                                <img src="{{ asset('assets/images/device.png')}}" alt="avtar img holder"
                                                    height="45" width="45">
                                            </div>
                                            <div class="user-page-info">
                                                <p class="mb-0 gray font-small-4">Device</p>
                                                <span
                                                    class="font-small-3">{{ $user->device_type == '1' ? 'Android' : 'IOS' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-start align-items-center mb-1">
                                            <div class="avatar mr-1">
                                                <img src="{{ asset('assets/images/push-token.png')}}"
                                                    alt="avtar img holder" height="45" width="45">
                                            </div>
                                            <div class="user-page-info">
                                                <p class="mb-0 gray font-small-4">Push Token</p>
                                                <span class="font-small-3">{{ $user->device_token }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-start align-items-center mb-1">
                                            <div class="avatar mr-1">
                                                <img src="{{ asset('assets/images/account-created.png')}}"
                                                    alt="avtar img holder" height="45" width="45">
                                            </div>
                                            <div class="user-page-info">
                                                <p class="mb-0 gray font-small-4">Account Created At</p>
                                                <span
                                                    class="font-small-3">{{ $user->created_at->timezone($app_settings['timezone'])->format('M d, Y') }}
                                                    at
                                                    {{ $user->created_at->timezone($app_settings['timezone'])->format('g:iA') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-1">
                            <div>
                                <p><strong>ADDRESSES</strong></p>
                            </div>
                            <button class="btn btn-warning btn-sm" onclick="showAddressModal()" id="addAddressBtn">Add New</button>
                        </div>

                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    @forelse ($user->addresses as $address)
                                    <div class="col-xl-6 col-md-12 col-sm-12">
                                        <div class="d-flex justify-content-start align-items-top mb-1">
                                            <div class="avatar mr-1">
                                                <img src="{{ asset('assets/images/address-icon.png')}}"
                                                    alt="avtar img holder" height="45" width="45">
                                            </div>
                                            <div class="user-page-info">
                                                <p class="mb-0 font-small-4">
                                                    <strong>
                                                        {{ $address->title }}
                                                        <span class="text-right pull-right text-warning" onclick="showAddressModal({{ $address->id }})">
                                                            <i class="fa fa-edit"></i>
                                                        </span>
                                                    </strong>
                                                </p>
                                                <span class="mb-0 font-small-3">
                                                    {{ $address->address_line_1 . ',' ?? '' }}
                                                    {{ $address->address_line_2 . ',' ?? '' }}
                                                    {{ $address->city()->first()->name . ',' ?? '' }}
                                                    {{ $address->country()->first()->country_name ?? '' }}
                                                </span><br>
                                                <span class="font-small-1 gray">Longitute:
                                                    {{ number_format($address->latitude, 2) }}
                                                    Latitude: {{ number_format($address->longitude, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-xl-12 col-md-12 col-sm-12">
                                        <p class="text-center p-2">No address details found.</p>
                                    </div>
                                    @endforelse
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-1">
                            <div>
                                <p><strong>MATCHMAKER</strong></p>
                            </div>
                            <p class="gray font-small-3">
                                Updated:
                                @if(!empty($last_update_match))
                                    {{ $last_update_match->timezone($app_settings['timezone'])->format('M d,Y') ?? '-' }} at
                                    {{ $last_update_match->timezone($app_settings['timezone'])->format('g:iA') ?? '' }}</p>
                                @else
                                    Not Available
                                @endif
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <ol class="pl-1">
                                    @forelse ($match_makers as $match_maker)
                                    <li class="gray mb-1 font-small-3">
                                        {{ $match_maker->question }}
                                        <br><span class="text-gray-dark">{{ $match_maker->values_name }}</span>
                                    </li>

                                    @empty
                                    <li class="gray mb-1 font-small-3">
                                        <span class="text-gray-dark text-center">No details found.</span>
                                    </li>

                                    @endforelse
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="card h-auto">
                        <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-1">
                            <div>
                                <p class="mb-75"><strong>REWARD STATUS</strong></p>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="rewara-status-icon">
                                    <ul>
                                        @for ($i = 1; $i <= 10; $i++)
                                        @if ($user->user_reward_points > 10)
                                        {{-- <li class="{{ $user->user_reward_points % 10 > 0 && ($user->user_reward_points / 10) >= $i ? 'active' : '' }}">
                                            <img src="{{ asset('assets/images/coffee-bag-red-copy-4.svg')}}" alt="avtar img holder" fill="#000" height="45"
                                                width="45">
                                        </li> --}}
                                        <li class="{{ ($user->user_reward_points % 10) >= $i ? 'active' : '' }}">
                                            <img src="{{ asset('assets/images/coffee-bag-red-copy-4.svg')}}" alt="avtar img holder" fill="#000" height="45"
                                                width="45">
                                        </li>
                                        @else
                                        <li
                                            class="{{ $user->user_reward_points >= $i ? 'active' : '' }}">
                                            <img src="{{ asset('assets/images/coffee-bag-red-copy-4.svg')}}"
                                                alt="avtar img holder" fill="#000" height="45" width="45">
                                            </li>
                                        @endif
                                            @endfor
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card h-auto">
                        <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-1">
                            <div>
                                <p class="mb-75"><strong>REWARD POINTS</strong></p>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="avatar-div mr-1">
                                                <img src="{{ asset('assets/images/coffee-bag-red.svg')}}">
                                            </div>
                                            <div class="user-page-info">
                                                <p class="mb-0 gray font-small-4">Reward Points</p>
                                                <span class="font-small-3">{{ $user->user_reward_points ?? 0 }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-1">
                            <div>
                                <p class="mb-75"><strong>ADD/EDIT REWARD POINTS</strong></p>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <p class="text-orange font-bold-700">UPDATE REWARD POINTS</p>
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <div class="form-group">
                                                    <label>ENTER POINTS</label>
                                                    <input type="text" class="form-control" placeholder="Enter Points" value="{{ $user->user_reward_points }}" id="user_reward_points" name="user_reward_points"/>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button"
                                                        class="btn btn-primary font-weight-bold btn-lg  waves-effect waves-light px-2"
                                                        onclick="updateRewards()">SAVE & UPDATE</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="note mt-2">
                                            <p class="font-small-3 font-bold-500 mb-0">
                                                {{ 'Last Updated: ' . (!empty($last_user_reward) ? $last_user_reward->created_at->timezone($app_settings['timezone'])->format("F d, Y g:iA") : '-') }}</p>
                                            <p class="font-small-3 font-bold-500 mb-0">
                                                Updated Via: {{ !empty($last_user_reward->user_id) ? 'Mobile App - Order' : 'Admin' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="tab-pane" id="orders" aria-labelledby="orders-tab" role="tabpanel">
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
                                        <div class="col-lg-7 col-md-7">

                                            <fieldset class="form-group position-relative has-icon-right mb-1 mr-0">
                                                <input type="text" class="form-control form-control-lg" id="search_order"
                                                    placeholder="Search by order#…">
                                                <div class="form-control-position">
                                                    <i class="feather icon-search px-1"></i>
                                                </div>
                                            </fieldset>

                                        </div>
                                        <div class="col-lg-5 col-md-5">
                                            <div class="d-flex justify-content-between align-items-top w-100">
                                                <button type="button"
                                                    class="btn btn-orange mr-1 mb-1 waves-effect waves-light px-5 btn-lg" id="search_btn">SEARCH</button>
                                                <a href="javascript:" class="btn btn-outline-orange mr-1 mb-1 waves-effect waves-light px-5 btn-lg"
                                                    id="exportBtn">EXPORT</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                        <a class="nav-link" id="all-orders-justified" data-toggle="tab"
                                            href="#all-orders" role="tab" aria-selected="false">VIEW ALL ({{ $all_orders }})</a>
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
                                                        {{-- <th class="w-12 font-small-3 text-bold-700">POINTS</th> --}}
                                                        <th class="w-12 font-small-3 text-bold-700">PAYMENT<br>STATUS</th>
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
                                                        {{-- <th class="w-12 font-small-3 text-bold-700">POINTS</th> --}}
                                                        <th class="w-12 font-small-3 text-bold-700">PAYMENT<br>STATUS</th>
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
                                                        {{-- <th class="w-12 font-small-3 text-bold-700">POINTS</th> --}}
                                                        <th class="w-12 font-small-3 text-bold-700">PAYMENT<br>STATUS</th>
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
                                                        {{-- <th class="w-12 font-small-3 text-bold-700">POINTS</th> --}}
                                                        <th class="w-12 font-small-3 text-bold-700">PAYMENT<br>STATUS</th>
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
                                                        {{-- <th class="w-12 font-small-3 text-bold-700">POINTS</th> --}}
                                                        <th class="w-12 font-small-3 text-bold-700">PAYMENT<br>STATUS</th>
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
                                                        {{-- <th class="w-12 font-small-3 text-bold-700">POINTS</th> --}}
                                                        <th class="w-12 font-small-3 text-bold-700">PAYMENT<br>STATUS</th>
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
</div>

<div class="modal fade text-left" id="edit-user" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">EDIT USER DETAILS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:" name="editUserForm"
                id="editUserForm" method="post" onsubmit="return false;">
                @csrf
                {{-- <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}" /> --}}
                <div class="modal-body">
                    <div class="form-group">
                        <label>FULL NAME</label>
                        <input name="full_name" id="full_name" class="form-control" value="{{ $user->name }}"/>
                    </div>
                    <div class="form-group">
                        <label>EMAIL</label>
                        <input name="email" id="email" class="form-control" value="{{ $user->email }}" />
                    </div>
                    <div class="form-group">
                        <label>PUSH TOKEN</label>
                        <input name="device_token" id="device_token" class="form-control" value="{{ $user->device_token }}" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="saveUser()" class="btn btn-primary font-weight-bold btn-lg w-30">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="add-edit-address" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">USER ADDRESS DETAILS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:" name="editAddressForm" id="editAddressForm" method="post" onsubmit="return false;">
                @csrf
                {{-- <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}" /> --}}
                <input type="hidden" name="address_id" id="address_id" value="" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>COUNTRY</label>
                                {{-- <input name="country_id" id="country_id" class="form-control" value="" /> --}}
                                <select name="country_id" id="country_id" class="form-control" required>
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>CITY</label>
                                {{-- <input name="city_id" id="city_id" class="form-control" value="" /> --}}
                                <select name="city_id" id="city_id" class="form-control"required>
                                    <option value="">Select City</option>
                                    @foreach ($countries as $country)
                                        @foreach ($country->cities as $city)
                                            <option class="country-{{ $country->id }}" value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>TITLE</label>
                        <input name="title" id="address_title" class="form-control" value="" required/>
                    </div>
                    <div class="form-group">
                        <label>ADDRESS LINE 1</label>
                        <input name="address_line_1" id="address_line_1" class="form-control" value="" required/>
                    </div>
                    <div class="form-group">
                        <label>ADDRESS LINE 2</label>
                        <input name="address_line_2" id="address_line_2" class="form-control" value="" required/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="saveAddress()"
                        class="btn btn-primary font-weight-bold btn-lg w-30">SAVE</button>
                </div>
            </form>
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
            $("#country_id").change(function() {
                $("#city_id").val('');
                $("#city_id").find("option").hide();
                $("#city_id").find("option:first").show();
                $("#city_id").find("option.country-" + $(this).val()).show();
            });

            $("#exportBtn").click(function() {
                location.href = BASE_URL + 'orders/export?user_id={{ $user->id }}';
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
                    data.user_id = '{{ $user->id }}';
                    data.status = 0;
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
                    "data": "payment_status_text",
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
                    data.user_id = '{{ $user->id }}';
                    data.status = 1;
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
                    "data": "payment_status_text",
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
                    data.user_id = '{{ $user->id }}';
                    data.status = 2;
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
                    "data": "payment_status_text",
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
                    data.user_id = '{{ $user->id }}';
                    data.status = 3;
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
                    "data": "payment_status_text",
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
                    data.user_id = '{{ $user->id }}';
                    data.status = 4;
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
                    "data": "payment_status_text",
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
                    data.user_id = '{{ $user->id }}';
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
                    "data": "payment_status_text",
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

        function updateRewards() {
            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('user_id', '{{ $user->id }}');
            formData.append('reward_points', $("#user_reward_points").val());

            $.ajax({
                url: "{{ url('admin/users/update') }}",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === true) {
                        toastr.success(response.message, 'Success', toastrOptions);
                        setTimeout(() => {
                            location.reload();
                        }, 200);
                    }
                    else {
                        toastr.error(response.message, 'Error', toastrOptions);
                    }
                },
                error: function(error) {}
            });
        }

        function saveUser(type) {
            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('user_id', '{{ $user->id }}');
            if(type !== null && type == 'status') {
                formData.append('status', $("#user_status").val());
            }
            else {
                formData.append('name', $("#full_name").val());
                formData.append('email', $("#email").val());
                formData.append('device_token', $("#device_token").val());
            }

            $.ajax({
                url: "{{ url('admin/users/update') }}",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === true) {
                        toastr.success(response.message, 'Success', toastrOptions);
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                    else {
                        toastr.error(response.message, 'Error', toastrOptions);
                    }
                },
                error: function(error) {}
            });
        }

        function saveAddress() {
            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('user_id', '{{ $user->id }}');
            formData.append('address_id', $("#address_id").val());
            formData.append('country_id', $("#country_id").val());
            formData.append('city_id', $("#city_id").val());
            formData.append('title', $("#address_title").val());
            formData.append('address_line_1', $("#address_line_1").val());
            formData.append('address_line_2', $("#address_line_2").val());

            $.ajax({
                url: "{{ url('admin/users/addresses/save') }}",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === true) {
                        toastr.success(response.message, 'Success', toastrOptions);
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                    else {
                        toastr.error(response.message, 'Error', toastrOptions);
                    }
                },
                error: function(error) {}
            });
        }

        function showAddressModal(id) {
            $("#address_id").val('');
            let addresses = JSON.parse('@json($user->addresses)');
            let curAddress;
            $("#editAddressForm")[0].reset();
            if(id !== undefined && id !== null && id.toString().length > 0) {
                $("#address_id").val(id);
                curAddress = addresses.filter(x => parseInt(x.id) === parseInt(id))[0];
                $("#country_id").val(curAddress.country_id);

                $("#city_id").find("option").hide();
                $("#city_id").find("option:first").show();
                $("#city_id").find("option.country-" + curAddress.country_id).show();

                $("#city_id").val(curAddress.city_id);
                $("#address_title").val(curAddress.title);
                $("#address_line_1").val(curAddress.address_line_2);
                $("#address_line_2").val(curAddress.address_line_1);
            }
            $("#add-edit-address").modal("show");
        }
</script>
@endsection
