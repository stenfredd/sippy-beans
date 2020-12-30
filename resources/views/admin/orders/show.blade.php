@extends('layouts.app')
@section('content')
<div class="service-requests-details">
    <div class="row">
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-2">
                <div class="card-header text-center pt-2 pb-2 w-100 d-block border-bottom">
                    <h2 class="text-center mb-0"><b>ORDER #{{ $order->order_number ?? '' }}</b></h2>
                </div>
                <div class="card-content border-t-1">
                    <div class="knowledge-panel text-center border-bottom">
                        <div class="card-body">
                            <div class="chart-info d-flex justify-content-between flex-wrap">
                                <div class="text-center pr-50  pl-0 col">
                                    <small class="gray font-small-2 text-bold-500"><b>Order Value</b></small>
                                    <p class="mb-0 font-small-2 font-weight-bold">
                                        {{ $app_settings['currency_code'] .' '. number_format(($order->total_amount ?? 0),2) }}</p>
                                </div>
                                <div class="text-center pr-50  pl-0 col">
                                    <small class="gray font-small-2 text-bold-500">Payment</small>
                                    <div class="d-flex align-items-center justify-content-center">
                                        @if (strtolower($order->payment_type ?? '') == 'card')
                                        <img src="{{ asset('assets/images/'.$order->card_type.'.png')}}" width="25%">
                                        <span class="mb-0 font-small-2 font-weight-bold">****
                                            {{ $order->card_number ?? '' }}</span>
                                        @else
                                        <span class="mb-0 font-small-2 font-weight-bold">Cash</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-center pr-0  pl-0 col">
                                    <small class="gray font-small-2 text-bold-500">Gateway</small>
                                    @if (strtolower($order->payment_type ?? '') == 'card')
                                    <p class="mb-0 font-small-2 font-weight-bold">
                                        <img src="{{ asset('assets/images/slack-logo.png') }}" height="15px"/>
                                    </p>
                                    @else
                                    <p class="mb-0 font-small-2 font-weight-bold">-</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="service-loction border-bottom">
                        <div class="card-body">
                            <p class="mb-0 font-small-4 gray text-bold-700">Delivery Address</p>

                            <div class="customer-select">
                                <div class="ui dropdown selection pointing selection-dropdown pl-0 hover-icon"
                                    tabindex="0">
                                    <select id="address_id" name="address_id" onchange="updateOrder('address')">
                                        @if (!empty($order->user->addresses))
                                        @foreach ($order->user->addresses as $address)

                                        <option value="{{ $address->id }}"
                                            {{ $order->address_id == $address->id ? 'selected' : '' }}>
                                            <p class="mb-0 font-small-4"><strong>{{ $address->title }} <i
                                                        class="fontawesome fa fa-sort-desc ml-50 text-orange drop-arrow"></i></strong>
                                            </p>
                                            <p class="text-bold-500 font-small-3 mb-0">
                                                {{ $address->address_line_1 . ',' ?? '' }}
                                                {{ $address->address_line_2 . ',' ?? '' }}
                                            </p>
                                            <p class="text-bold-500  font-small-3 mb-0">
                                                {{ $address->city()->first()->name . ',' ?? '' }}
                                                {{ $address->country()->first()->country_name ?? '' }}</p>
                                            <p class="text-bold-500  font-small-2 gray mb-0">Longitute:
                                                {{ number_format($address->latitude, 2) }}
                                                Latitude: {{ number_format($address->longitude, 2) }}</p>
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <div class="default text"></div>
                                    <div class="menu" tabindex="-1">
                                        <div class="header font-small-4 font-weight-bold">
                                            <span class="font-small-4 font-weight-bold">SELECT SERVICE LOCATION</span>
                                        </div>

                                        @if (!empty($order->user->addresses))
                                        @foreach ($order->user->addresses as $address)

                                        <div class="item border-bottom" data-value="{{ $address->id }}">
                                            <p class="mb-0 font-small-4"><strong>{{ $address->title }} <i
                                                        class="fontawesome fa fa-sort-desc ml-50 text-orange drop-arrow"></i></strong>
                                            </p>
                                            <p class="text-bold-500 font-small-3 mb-0">
                                                {{ $address->address_line_1 . ',' ?? '' }}
                                                {{ $address->address_line_2 . ',' ?? '' }}
                                            </p>
                                            <p class="text-bold-500  font-small-3 mb-0">
                                                {{ $address->city()->first()->name . ',' ?? '' }}
                                                {{ $address->country()->first()->country_name ?? '' }}</p>
                                            <p class="text-bold-500  font-small-2 gray mb-0">Longitute:
                                                {{ number_format($address->latitude, 2) }}
                                                Latitude: {{ number_format($address->longitude, 2) }}</p>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-users-view border-bottom">
                        <div class="card-body">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="text-bold-500 gray font-small-3">Customer</td>
                                        <td class="font-weight-bold font-small-3 customer-select">
                                            <div class="ui dropdown selection pointing selection-dropdown pl-0 hover-icon hide-no"
                                                tabindex="0">
                                                <select id="user_id" name="user_id" {{ !empty($order) ? 'disabled' : '' }}>
                                                    <option value="">Select Customer</option>
                                                    @foreach ($users as $user)

                                                    <option value="{{ $user->id }}"
                                                        {{ $order->user_id == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}<br>
                                                        <span class="pt-25 font-small-1 inline-block gray">
                                                            {{ $user->country_code .' '. $user->phone }}
                                                        </span>
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @if(empty($order))
                                                <i class="dropdown icon text-orange px-0"></i>
                                                @endif
                                                <div class="default text">{{ $order->user->name ?? 'Select Customer' }}</div>
                                                <div class="menu">
                                                    <div class="ui icon search input">
                                                        <i class="icon feather icon-search"></i>
                                                        <input type="text" placeholder="Search Customer">
                                                    </div>
                                                    <div class="header font-weight-bold font-small-3">
                                                        {{ $order->user->name ?? 'SELECT CUSTOMER' }}
                                                    </div>
                                                    <div class="scrolling menu">
                                                        @if(empty($order))
                                                        @foreach ($users as $user)
                                                        <div class="item font-weight-bold font-small-3 pt-1 pb-1 border-bottom"
                                                            data-value="{{ $user->id }}"
                                                            onclick="$('#user_id').val({{ $user->id }})">
                                                            {{ $user->name }}<br><span
                                                                class="pt-25 font-small-1 inline-block gray">{{ $user->country_code .' '. $user->phone }}</span>
                                                        </div>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold-500 gray font-small-3">Contact No.</td>
                                        <td class="font-weight-bold font-small-3">
                                            {{ ($order->user->country_code ?? '') .' '. ($order->user->phone ?? '') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold-500 gray font-small-3">Email Address</td>
                                        <td class="font-weight-bold font-small-3">{{ ($order->user->email ?? '-') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="page-users-view">
                        <div class="card-body">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="text-bold-500 gray font-small-3">Ordered At</td>
                                        <td class="font-weight-bold font-small-3">
                                            {{ $order->created_at->timezone($app_settings['timezone'])->format("l M d,Y g:iA") ?? '-'}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold-500 gray font-small-3">Ordered Via</td>
                                        <td class="font-weight-bold font-small-3">Mobile App
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <img src="{{ asset('assets/images/sippy-logo-full-order.png')}}" alt="users avatar"
                            class="users-avatar-shadow rounded mr-2 r-img" height="90" width="115">
                        <div class="media-body">
                            <div class="text-left">
                                <small class="gray text-bold-500">Serviced By</small>
                                <p class="mb-0 font-medium-3">SIPPY LTD<br><span class="font-small-2 gray">United Arab
                                        Emirates</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div
                            class="card-header d-flex justify-content-between align-items-center pb-2 pt-2 border-bottom">
                            <h4 class="mb-0 text-bold-700">ORDER DETAILS</h4>
                            <div class="ui pointing floating labeled icon dropdown hover-icon top right">
                                <select id="item_cancelltion" name="item_cancelltion" onchange="cancelItem()" class="form-control">
                                    <option value="cancel">Cancelled</option>
                                </select>
                                <div class="text">
                                    <span class="font-small-3 font-weight-bold">Options</span>
                                </div>
                                <div class="menu p-1">
                                    {{-- <div class="item border-bottom" onclick="$('#status').val(0);">
                                        <span class="font-small-3 font-weight-bold">New</span>
                                    </div>
                                    <div class="item border-bottom" onclick="$('#status').val(1);">
                                        <span class="font-small-3  font-weight-bold">In Progress</span>
                                    </div>
                                    <div class="item border-bottom" onclick="$('#status').val(2);">
                                        <span class="font-small-3 font-weight-bold">Shipped</span>
                                    </div>
                                    <div class="item border-bottom" onclick="$('#status').val(3);">
                                        <span class="font-small-3 font-weight-bold">Completed</span>
                                    </div> --}}
                                    <div class="item border-bottom" onclick="$('#item_cancelltion').val('cancel');">
                                        <span class="font-small-3 font-weight-bold">Cancelled</span>
                                    </div>
                                </div>
                                <i class="d-inline-block fontawesome fa fa-sort-desc ml-50 text-orange drop-arrow"></i>
                            </div>
                        </div>
                        <div class="card-content border-radius-bottom">
                            <div>
                                <div class="table-responsive pagenation-row">
                                    <table class="table table-striped table-hover-animation mb-0">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <fieldset>
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input type="checkbox" value="false" id="all_select">
                                                            <span class="vs-checkbox vs-checkbox-sm">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </fieldset>
                                                </th>
                                                <th scope="col" class="font-weight-bold font-small-3 border-top-0">ID
                                                </th>
                                                <th scope="col" class="font-weight-bold font-small-3 border-top-0">
                                                    ITEM</th>
                                                <th scope="col" class="font-weight-bold font-small-3 border-top-0">
                                                    SELLER</th>
                                                <th scope="col" class="font-weight-bold font-small-3 border-top-0">RATE
                                                </th>
                                                <th scope="col" class="font-weight-bold font-small-3 border-top-0">Qty
                                                </th>
                                                <th scope="col" class="font-weight-bold font-small-3 border-top-0">
                                                    AMOUNT</th>
                                                <th scope="col" class="font-weight-bold font-small-3 border-top-0">
                                                    CANCELLED</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->details as $k => $item)
                                            <tr>
                                                <td>
                                                    @if ($item->is_cancelled != 1)
                                                        <fieldset>
                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                <input type="checkbox" value="{{ $item->id }}" class="item_select">
                                                                <span class="vs-checkbox vs-checkbox-sm">
                                                                    <span class="vs-checkbox--check">
                                                                        <i class="vs-icon feather icon-check"></i>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </fieldset>
                                                    @endif
                                                </td>
                                                <td scope="row" class="font-weight-bold font-small-3">{{ $k + 1 }}</td>
                                                <td class="font-weight-bold font-small-4">
                                                    @if (!empty($item->subscription_id))
                                                    {{ $item->subscription->title }}
                                                    @elseif (!empty($item->equipment_id))
                                                    {{ $item->equipment->title }}
                                                    @else
                                                    {{ $item->product->product_name }}
                                                    @endif
                                                    <br>
                                                    <span class="text-bold-500 font-small-2 gray">
                                                        @if (!empty($item->product_id) && !empty($item->variant_id))
                                                        {{ $item->variant->title }} -
                                                        @endif
                                                        {{ $item->grind_title }}
                                                    </span>
                                                </td>
                                                <td class="font-weight-bold font-small-3">
                                                    @if (!empty($item->subscription_id))
                                                    SIPPY
                                                    @elseif (!empty($item->equipment_id))
                                                    {{ $item->equipment->brand->title }}
                                                    @else
                                                    {{ $item->product->brand->name }}
                                                    @endif
                                                </td>
                                                <td class="font-weight-bold font-small-3">
                                                    {{ $app_settings['currency_code'] .' '. number_format($item->amount,2) }}</td>
                                                <td class="font-weight-bold font-small-3">{{ $item->quantity }}</td>
                                                <td class="font-weight-bold font-small-3">
                                                    {{ $app_settings['currency_code'].' '. number_format($item->subtotal,2) }}</td>
                                                <td class="font-weight-bold font-small-3">
                                                    {{ $item->is_cancelled == 1 ? 'YES' : 'NO' }}
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
                <div class="col-lg-7 col-md-12">
                    <div class="card card-equal-hight">
                        <div class="card-body special-instructions">
                            <div class="d-flex justify-content-start align-items-top mb-2">
                                <div class="avatar mr-1">
                                    <div class="avatar-div mr-1">
                                        <img src="{{ asset('assets/images/coffee-bag.svg')}}">
                                    </div>
                                </div>
                                <div class="user-page-info">
                                    <div class="user-page-info">
                                        <p class="mb-0 gray font-small-4 text-bold-500">Reward Point(s)</p>
                                        <!-- <div class="ui dropdown hover-icon pointing d-inline-block">
                                 <span class="text font-small-4">3</span>
                                 <div class="menu">
                                   <div class="scrolling menu">
                                      <div class="item font-weight-bold font-small-3 pt-1 pb-1 border-bottom" data-value="Mohit Odhrani">
                                          3
                                       </div>
                                       <div class="item font-weight-bold font-small-3 pt-1 pb-1 border-bottom" data-value="Mohit Odhrani">
                                          4
                                       </div>
                                       <div class="item font-weight-bold font-small-3 pt-1 pb-1 border-bottom" data-value="Mohit Odhrani">
                                         5
                                       </div>
                                    </div>
                                 </div>
                                  <i class="d-inline-block fontawesome fa fa-sort-desc ml-50 text-orange drop-arrow"></i>
                              </div> -->
                                        <input type="number" name="reward_points" id="reward_points" min="0"
                                            value="{{ $order->reward_points }}" onchange="updateOrder('reward_points')">
                                        {{-- <div --}}
                                        {{-- class="ui dropdown selection pointing selection-dropdown pl-0 hover-icon hide-no"> --}}
                                        {{-- <i class="dropdown icon text-orange"></i> --}}
                                        {{-- <div class="default text pr-50">3</div> --}}
                                        {{-- <div class="menu w-80p">
                                                <div class="scrolling menu">
                                                    <div class="item font-weight-bold font-small-3 pt-1 pb-1 border-bottom"
                                                        data-value="1">
                                                        3
                                                    </div>
                                                    <div class="item font-weight-bold font-small-3 pt-1 pb-1 border-bottom"
                                                        data-value="2">
                                                        4
                                                    </div>
                                                    <div class="item font-weight-bold font-small-3 pt-1 pb-1 border-bottom"
                                                        data-value="3">
                                                        5
                                                    </div>
                                                </div>
                                            </div> --}}
                                        {{-- </div> --}}

                                    </div>

                                </div>
                            </div>
                            <div class="d-flex justify-content-start align-items-top mb-2">
                                <div class="avatar mr-1">
                                    <div class="avatar-div mr-1">
                                        <img src="{{ asset('assets/images/status.svg')}}">
                                    </div>
                                </div>
                                <div class="user-page-info">
                                    <p class="mb-0 gray font-small-4 text-bold-500">Status</p>
                                    <div class="status-options">
                                        <div class="ui dropdown selection pointing selection-dropdown pl-0 hover-icon">
                                            <select id="status" name="status" onchange="updateOrder('status')">
                                                <option value="1" {{ $order->status == '0' ? 'selected' : '' }}>New
                                                    Order</option>
                                                <option value="2" {{ $order->status == '1' ? 'selected' : '' }}>In
                                                    Progress</option>
                                                <option value="3" {{ $order->status == '2' ? 'selected' : '' }}>Shipped
                                                </option>
                                                <option value="4" {{ $order->status == '3' ? 'selected' : '' }}>
                                                    Completed</option>
                                                <option value="5" {{ $order->status == '4' ? 'selected' : '' }}>
                                                    Cancelled</option>
                                            </select>
                                            <i class="dropdown icon text-orange"></i>
                                            <div class="default text mr-50">
                                                {{-- <div class="d-inline-block selected mr-25">
                                                    <div class="color-option border-lighgreen">
                                                        <div class="filloption bg-lighgreen"></div>
                                                    </div>
                                                </div>
                                                <span class="font-small-3  font-weight-bold text-lighgreen">
                                                    New Order</span> --}}
                                            </div>
                                            <div class="menu p-1 w-250">
                                                <div class="header font-small-4 font-weight-bold">
                                                    <span class="font-small-4 font-weight-bold">SELECT Technician</span>
                                                </div>
                                                <div class="item border-bottom" data-value="1"
                                                    onclick="$('#status').val(0).trigger('change')">
                                                    <div class="d-inline-block selected mr-25">
                                                        <div class="color-option border-lighgreen">
                                                            <div class="filloption bg-lighgreen"></div>
                                                        </div>
                                                    </div>
                                                    <span class="font-small-3  font-weight-bold text-lighgreen">
                                                        New Order</span>
                                                </div>
                                                <div class="item border-bottom" data-value="2"
                                                    onclick="$('#status').val(1).trigger('change')">
                                                    <div class="d-inline-block selected mr-25">
                                                        <div class="color-option border-purple">
                                                            <div class="filloption bg-purple"></div>
                                                        </div>
                                                    </div>
                                                    <span class="font-small-3  font-weight-bold text-purple">
                                                        In Progress</span>
                                                </div>
                                                <div class="item border-bottom" data-value="3"
                                                    onclick="$('#status').val(2).trigger('change')">
                                                    <div class="d-inline-block selected mr-25">
                                                        <div class="color-option border-info">
                                                            <div class="filloption bg-info"></div>
                                                        </div>
                                                    </div>
                                                    <span class="font-small-3 font-weight-bold text-info">Shipped</span>
                                                </div>
                                                <div class="item border-bottom" data-value="4"
                                                    onclick="$('#status').val(3).trigger('change')">
                                                    <div class="d-inline-block selected mr-25">
                                                        <div class="color-option border-success">
                                                            <div class="filloption bg-success"></div>
                                                        </div>
                                                    </div>
                                                    <span class="font-small-3 font-weight-bold text-success">
                                                        Completed</span>
                                                </div>
                                                <div class="item border-bottom" data-value="5"
                                                    onclick="$('#status').val(4).trigger('change')">
                                                    <div class="d-inline-block selected mr-25">
                                                        <div class="color-option border-danger">
                                                            <div class="filloption bg-danger"></div>
                                                        </div>
                                                    </div>
                                                    <span class="font-small-3 font-weight-bold text-danger">
                                                        Cancelled</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start align-items-top mb-0">
                                <div class="avatar mr-1">
                                    <div class="avatar-div mr-1">
                                        <img src="{{ asset('assets/images/card.svg')}}">
                                    </div>
                                </div>
                                <div class="user-page-info">
                                    <p class="mb-0 gray font-small-4 text-bold-500">Payment Status</p>

                                    <div class="status-options">
                                        <div class="ui dropdown selection pointing selection-dropdown pl-0 hover-icon ">
                                            <select id="payment_status" name="payment_status" onchange="updateOrder('payment_status')">
                                                {{-- <option value="1"
                                                    {{ $order->total_amount == $order->payment_received ? 'selected' : '' }}>
                                                    Payment Received</option>
                                                <option value="2"
                                                    {{ $order->total_amount > $order->payment_received ? 'selected' : '' }}>
                                                    Payment Pending</option>
                                                <option value="3"
                                                    {{ $order->payment_received == 0 && ($order->status == 3 || $order->status == 4) ? 'selected' : '' }}>
                                                    Refunded</option> --}}
                                                    <option value="">Payment Status</option>
                                                    <option value="1" {{ $order->payment_status == '1' ? 'selected' : '' }}>Payment Pending</option>
                                                    <option value="2" {{ $order->payment_status == '2' ? 'selected' : '' }}>Payment Received</option>
                                                    <option value="3" {{ $order->payment_status == '3' ? 'selected' : '' }}>Partial Refund</option>
                                                    <option value="4" {{ $order->payment_status == '4' ? 'selected' : '' }}>Refunded</option>
                                            </select>
                                            <i class="dropdown icon text-orange"></i>
                                            <div class="default text mr-50">
                                                <div class="item">
                                                    @if($order->payment_status == '1' ? 'selected' : '')
                                                    <div class="d-inline-block mr-25">
                                                        <i class="fa fa-circle font-small-3 text-warning mr-50"></i>
                                                    </div>
                                                    <span class="font-small-3 font-weight-bold">
                                                        Payment Pending
                                                    </span>
                                                    @endif
                                                    @if($order->payment_status == '2' ? 'selected' : '')
                                                    <div class="Partial-option">
                                                        <div class="Partial-div d-inline-block mr-25">
                                                            <i class="fa fa-circle font-small-3 text-success mr-50"></i>
                                                        </div>
                                                        <span class="font-small-3 font-weight-bold">
                                                            Payment Received
                                                        </span>
                                                    </div>
                                                    @endif
                                                    @if($order->payment_status == '3' ? 'selected' : '')
                                                    <div class="d-inline-block mr-25">
                                                        {{-- <i class="fa fa-circle font-small-3 text-danger mr-50"></i> --}}
                                                        <div class="Partial-option">
                                                            <div class="Partial-div d-inline-block text-danger mr-25">
                                                                <div class="filloption"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="font-small-3 font-weight-bold">
                                                        Partial Refunded
                                                    </span>
                                                    @endif
                                                    @if($order->payment_status == '4' ? 'selected' : '')
                                                    <div class="d-inline-block mr-25">
                                                        <i class="fa fa-circle font-small-3 text-danger mr-50"></i>
                                                    </div>
                                                    <span class="font-small-3 font-weight-bold">
                                                        Refunded
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="menu p-1 w-250">
                                                <div class="header font-small-4 font-weight-bold">
                                                    <span class="font-small-4 font-weight-bold">Payment Status</span>
                                                </div>
                                                <div class="item border-bottom" onclick="$('#payment_status').val(1).trigger('change')">
                                                    <div
                                                        class="d-inline-block {{ $order->payment_status == '1' ? 'selected' : '' }} mr-25">
                                                        <i class="fa fa-circle font-small-3 text-warning mr-50"></i>
                                                    </div>
                                                    <span class="font-small-3 font-weight-bold">
                                                        Payment Pending</span>
                                                </div>

                                                <div class="item border-bottom" onclick="$('#payment_status').val(2).trigger('change')">
                                                    <div
                                                        class="d-inline-block {{ $order->payment_status == '2' ? 'selected' : '' }} mr-25">
                                                        <i class="fa fa-circle font-small-3 text-success mr-50"></i>
                                                    </div>
                                                    <span class="font-small-3 font-weight-bold">
                                                        Payment Received</span>
                                                </div>
                                                <div class="item border-bottom" onclick="$('#payment_status').val(3).trigger('change')">
                                                    <div
                                                        class="d-inline-block {{ $order->payment_status == '3' ? 'selected' : '' }} mr-25">
                                                        <div class="Partial-option">
                                                            <div class="Partial-div d-inline-block text-danger mr-25">
                                                                <div class="filloption"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="font-small-3 font-weight-bold">
                                                        Partial Refunded</span>
                                                </div>
                                                <div class="item border-bottom" onclick="$('#payment_status').val(4).trigger('change')">
                                                    <div class="d-inline-block {{ $order->payment_status == '4' ? 'selected' : '' }} mr-25">
                                                        <i class="fa fa-circle font-small-3 text-danger mr-50"></i>
                                                    </div>
                                                    <span class="font-small-3 font-weight-bold">
                                                        Refunded</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="Partial-option">
                           <div class="Partial-div d-inline-block selected mr-25">
                              <div class="filloption"></div>
                           </div>
                           <span class="font-small-3">
                           Partial Payment</span>
                        </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 balance-payable-view">
                    <div class="card card-equal-hight border-radius-bottom">
                        <div class="card-body">
                            <table class="w-100">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold font-small-3">Cart Total</td>
                                        <td class="font-small-3 text-right">{{ $app_settings['currency_code'] }}
                                            {{ number_format($order->cart_total, 2) }}
                                        </td>
                                        <td class="w-5"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold font-small-3">Delivery Fee</td>
                                        <td class="font-small-3 text-right">{{ $app_settings['currency_code'] }}
                                            {{ number_format($order->delivery_fee, 2) }}
                                        </td>
                                        <td class="w-5"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold font-small-3">Discount/Promo</td>
                                        <td class="font-small-3 text-right">{{ $app_settings['currency_code'] }}
                                            {{ number_format($order->total_discount, 2) }}
                                        </td>
                                        <td class="w-5"><a href="#" id="discount-btn" data-toggle="modal"
                                                data-target="#discount-promo"><i
                                                    class="feather icon-edit font-medium-1"></i></a></td>
                                    </tr>
                                    <tr class="Subtotal border-top">
                                        <td class="font-small-3">Subtotal</td>
                                        <td class="font-small-3 text-right">{{ $app_settings['currency_code'] }}
                                            {{ number_format($order->subtotal, 2) ?? 0 }}</td>
                                        <td class="w-5"></td>
                                    </tr>
                                    <tr class="Subtotal">
                                        <td class="font-small-3">Tax & Charges</td>
                                        <td class="font-small-3 text-right">{{ $app_settings['currency_code'] }}
                                            {{ number_format($order->tax_charges, 2) ?? 0 }}</td>
                                        <td class="w-5"></td>
                                    </tr>
                                    <tr class="Subtotal border-top">
                                        <td class="font-small-3">Total</td>
                                        <td class="font-small-3 text-right">{{ $app_settings['currency_code'] }}
                                            {{ number_format($order->total_amount, 2) ?? 0 }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="font-small-3">Total Paid</td>
                                        <td class="font-small-3 text-right">{{ $app_settings['currency_code'] }}
                                            {{ number_format($order->payment_received, 2) ?? 0.00 }}</td>
                                        <td class="w-5"></td>
                                    </tr>

                                    <tr class="border-top">
                                        <td class="font-small-3">Pending Refund</td>
                                        <td class="font-small-3 text-right">{{ $app_settings['currency_code'] }}
                                            {{ number_format($order->pending_refund, 2) ?? 0.00 }}</td>
                                        <td class="w-5"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-small-3">Total Refund</td>
                                        <td class="font-small-3 text-right">{{ $app_settings['currency_code'] }}
                                            {{ number_format($order->total_refund, 2) ?? 0.00 }}</td>
                                        <td class="w-5"></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3" class="font-small-2 gray text-bold-500">Promo Used:
                                            {{ $order->promocode ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-content bg-light-orange">
                            <div class="card-body pb-50 pt-50">
                                <div class="table-responsive">
                                    <table class="w-100">
                                        <tr>
                                            <td class="font-small-3">Balance Payable<br><span
                                                    class="font-small-1 gray text-bold-500">Balance to be collected<br>
                                                    from customer.</span></td>
                                            <td class="font-small-3 vertical-align-top text-orange text-right">
                                                {{ number_format($order->balance_amount, 2) ?? '0.00' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div
                            class="card-header d-flex justify-content-between align-items-center pb-2 pt-2 border-bottom">
                            <h4 class="mb-0">PAYMENT LOG</h4>
                            <a href="javascript:" type="button"
                                class="btn custtam-btn square  waves-effect waves-light text-bold-700"
                                id="add-transcation">Add New Transcation</a>
                        </div>
                        <div class="payment-log">
                            <div class="card-content">
                                <div class="list-group analytics-list">
                                    @foreach ($order->transactions as $transaction)
                                    <div
                                        class="list-group-item d-lg-flex justify-content-between align-items-center py-1">
                                        <div class="float-left">
                                            <div class="d-flex  align-items-start">
                                                <div class="avatar bg-rgba-success p-50 m-0">
                                                    <div class="avatar-content">
                                                        @if ($transaction->payment_type == 'payment')
                                                        <i class="fa fa-usd text-success font-medium-5"></i>
                                                        @else
                                                        <img src="{{ asset('assets/images/refund-icon.svg')}}">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="ml-1">
                                                    <p class="text-bold-700 font-small-3  mb-0">
                                                        {{ ucfirst($transaction->payment_type) }} processed
                                                        succesfully -
                                                        {{ $app_settings['currency_code'] }}&nbsp;{{ number_format($transaction->amount,2) }}
                                                    </p>
                                                    <small class="text-bold-500 font-small-2 gray">
                                                        @if ($transaction->type == 'card')
                                                        Via Stripe.com - Transcation #{{ $transaction->payment_id }},
                                                        {{ ucfirst($order->card_type) }} ****{{ $order->card_number }}
                                                        @else
                                                        Cash
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="float-right d-flex  align-items-start">
                                            <p class="pr-1 font-small-3 gray text-bold-500">
                                                {{ $transaction->created_at->timezone($app_settings['timezone'])->format('M d, Y g:iA') }}
                                            </p>
                                            <a href="#" class="gray"><i class="fa fa-ellipsis-v"></i></a>
                                        </div>
                                    </div>
                                    @endforeach
                                    @if (empty($order->transactions) || count($order->transactions) == 0)
                                        <div class="text-center pt-2 pb-2">
                                            No payment log details found.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-12 col-md-12">
                    <div class="card activity-log">
                        <div
                            class="card-header d-flex justify-content-between align-items-center pb-2 pt-2 border-bottom">
                            <h4 class="mb-0">ACTIVITY LOG</h4>
                        </div>
                        <div class="payment-log">
                            <div class="card-content">
                                <div class="list-group analytics-list">
                                    <div
                                        class="list-group-item d-lg-flex justify-content-between align-items-center py-1">
                                        <div class="float-left">
                                            <div class="d-flex  align-items-start">
                                                <div class="avatar p-50 m-0">
                                                    <div class="avatar-content">
                                                        <img src="{{ asset('assets/images/activity-icon.png')}}"
                alt="avtar img holder" height="45" width="45">
            </div>
        </div>
        <div class="ml-1">
            <p class="text-bold-500 font-small-3  mb-0">Service Location -<b>
                    Updated</b></p>
            <small class="text-bold-700 font-small-2 gray">Admin changed service
                location from Office to Home</small>
        </div>
    </div>
</div>
<div class="float-right">
    <p class="font-small-3 gray text-bold-500">September 5, 2020 at 11:30AM <br>
        <span class=" text-bold-700 font-small-3 gray">Updated by: Yogi Fixes
            Admin</span>
    </p>
</div>
</div>
<div class="list-group-item d-lg-flex justify-content-between align-items-center py-1">
    <div class="float-left">
        <div class="d-flex  align-items-start">
            <div class="avatar p-50 m-0">
                <div class="avatar-content">
                    <img src="{{ asset('assets/images/activity-icon.png')}}" alt="avtar img holder" height="45"
                        width="45">
                </div>
            </div>
            <div class="ml-1">
                <p class="text-bold-500 font-small-3  mb-0">Service Location -
                    <b>Updated</b></p>
                <small class="text-bold-700 font-small-2 gray">Admin changed service
                    location from Office to Home</small>
            </div>
        </div>
    </div>
    <div class="float-right">
        <p class="font-small-3 text-bold-500 gray">September 5, 2020 at 11:30AM <br>
            <span class="font-small-3 gray text-bold-700">Updated by: Yogi Fixes
                Admin</span>
        </p>
    </div>
</div>
<div class="list-group-item d-lg-flex justify-content-between align-items-center py-1">
    <div class="float-left">
        <div class="d-flex  align-items-start">
            <div class="avatar bg-rgba-muted p-50 m-0">
                <div class="avatar-content">
                    <img src="{{ asset('assets/images/activity-icon.png')}}" alt="avtar img holder" height="45"
                        width="45">
                </div>
            </div>
            <div class="ml-1">
                <p class="text-bold-500 font-small-3  mb-0">Service Location -
                    <b>Updated</b></p>
                <small class="text-bold-700 font-small-2 gray">Admin changed service
                    location from Office to Home</small>
            </div>
        </div>
    </div>
    <div class="float-right">
        <p class="font-small-3 gray text-bold-500">September 5, 2020 at 11:30AM <br>
            <span class="font-small-3 gray text-bold-700">Updated by: Yogi Fixes
                Admin</span>
        </p>
    </div>
</div>
</div>
</div>
</div>
</div>
</div> --}}
</div>
</div>
</div>
</div>
<!--Add Add New Transcation-->
<div class="modal fade text-left" id="add-new-transcation" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ADD PAYMENT LOG</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <label>TRANSACTION TYPE</label>
                    <div class="form-group">
                        <div class="ui fluid selection dropdown">
                            <input type="hidden" name="transaction type">
                            <i class="dropdown icon"></i>
                            <div class="default text">Select Transaction Type</div>
                            <div class="menu">
                                <div class="item" data-value="Payment">
                                    Payment
                                </div>
                            </div>
                        </div>
                    </div>
                    <label>TRANSACTION METHOD</label>
                    <div class="form-group">
                        <div class="form-group">
                            <div class="ui fluid selection dropdown">
                                <input type="hidden" name="transaction method">
                                <i class="dropdown icon"></i>
                                <div class="default text">Select Transaction Method</div>
                                <div class="menu">
                                    <div class="item" data-value="Payment">
                                        Payment Link
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label>AMOUNT</label>
                            <select class="ui search dropdown w-100">
                                <option value="">{{ $app_settings['currency_code'] }}X.XX</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label>TRANSACTION ID</label>
                            <input type="text" placeholder="Reference Code" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary font-weight-bold btn-lg w-30"
                        data-dismiss="modal">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add New Service modal-->
<!--Add Add New Transcation-->
<div class="modal fade text-left" id="discount-promo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">DISCOUNT/PROMO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <label>PROMO CODE</label>
                    <div class="form-group">
                        <input type="text" placeholder="Promocode" class="form-control" id="promocode" name="promocode">
                    </div>
                    <p class="text-orange">OR MANUAL AMOUNT ENTRY</p>
                    <label>ENTER DISCOUNT AMOUNT</label>
                    <div class="form-group">
                        <select name="discount_type" id="discount_type" class="form-control">
                            <option value="percentage">Percentage</option>
                            <option value="amount">Fixed Amount</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="X.XX" id="discount_amount" name="discount_amount"
                            class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="updateOrder('discount')" type="button"
                        class="btn btn-primary font-weight-bold btn-lg w-30">SAVE
                        & APPLY</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add New Service modal-->
<!--Add Add New Transcation-->
{{-- <div class="modal fade text-left" id="special-instructions" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Special Instructions</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <label>Input special instructions here.</label>
                    <div class="form-group">
                        <input type="text" placeholder="Input special instructions here." class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary font-weight-bold btn-lg w-30" data-dismiss="modal">SAVE
                        & APPLY</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
<!--End Add New Service modal-->
@endsection


@section('scripts')
<script type="text/javascript">

    $(document).ready(function() {
        $("#all_select").change(function() {
            $(".item_select").prop('checked', this.checked);
        });

        $(".item_select").change(function() {
            if($(".item_select:checked").length === $(".item_select").length) {
                $("#all_select").prop("checked", true);
            }
            else {
                $("#all_select").prop("checked", false);
            }
        });
    });

    function updateOrder(type = null) {
            if (type === null) {
                return false;
            }
            let formData = new FormData();
            formData.append('order_id', '{{ $order->id }}');
            formData.append('_token', '{{ csrf_token() }}');
            if (type === 'address') {
                formData.append('address_id', $("#address_id").val());
            } else if (type === 'reward_points') {
                formData.append('reward_points', $("#reward_points").val());
            } else if (type === 'status') {
                formData.append('status', $("#status").val());
            } else if (type === 'payment_status') {
                formData.append('payment_status', $("#payment_status").val());
            } else if (type === 'discount') {
                formData.append('promocode', $("#promocode").val());
                formData.append('discount_type', $("#discount_type").val());
                formData.append('discount_amount', $("#discount_amount").val());
                formData.append('user_id', '{{ $order->user_id }}');
            }

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
                        if (type === 'discount') {
                            $("#discount-promo").modal('hide');
                        }
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error(response.message, 'Error', {
                            "closeButton": true,
                            "progressBar": true,
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            "timeOut": 2000
                        });
                    }
                },
                error: function(error) {}
            });
        }

        function cancelItem() {
            if($(".item_select:checked").length === 0) {
                toastr.error("Please select atleast 1 item to cancel.", 'Warning', toastrOptions);
                return false;
            }
            let ids = [];
            $(".item_select:checked").each(function(){
                ids.push($(this).val());
            });

            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('order_id', '{{ $order->id }}');
            formData.append('detail_ids', ids);

            $.ajax({
                url: "{{ url('admin/orders/cancel-items') }}",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === true) {
                        toastr.success(response.message, 'Success', toastrOptions);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error(response.message, 'Error', toastrOptions);
                    }
                },
                error: function(error) {}
            });
        }
</script>
@endsection
