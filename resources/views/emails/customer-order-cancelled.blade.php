<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="viewport" content="width=device-width">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <title>Customer Order Cancelled</title>
    <style type="text/css">
        a:hover {
            color: #f53e22 !important;
            text-decoration: underline !important
        }

        .wrapper {
            width: 100%;
            table-layout: fixed;
            font-family: 'Montserrat', Arial, Helvetica, sans-serif;
            font-weight: 600
        }

        .container {
            max-width: 595px;
        }

        .outer {
            Margin: 0 auto;
            width: 100%;
            max-width: 595px;
            border-spacing: 0;
            font-family: 'Montserrat', Arial, Helvetica, sans-serif;
            color: #333;
        }

        .product-two-column {
            text-align: center;
        }

        .two-column {
            text-align: center;
            font-size: 0;
            line-height: 0;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .two-column .column {
            width: 50%;
            display: inline-block;
            vertical-align: top;
        }

        .two-column .content {
            font-size: 15px;
            line-height: 20px;
            text-align: left
        }

        .two-column .content-right {
            text-align: right
        }

        .padding {
            padding: 0px 25px;
        }

        .product-left {
            display: inline-block;
            width: 60%;
            vertical-align: top;
        }

        .product-right {
            display: inline-block;
            width: 38%;
            text-align: right;
            vertical-align: top;
        }

        .product-right td {
            display: block
        }

        .product-right tbody {
            display: block;
            text-align: right
        }

        .product-right tbody tr {
            display: block;
            font-family: 'Proxima Nova Regular', Arial, Helvetica, sans-serif;
        }

        @media only screen and (max-width: 480px) {
            .padding {
                padding: 0px 15px !important;
            }

            .two-column .content-right {
                text-align: left !important;
                display: inline-block !important;
            }

            .two-column .content {
                text-align: left !important;
                display: inline-block !important;
            }

            .two-column .column {
                width: 100% !important;
                display: inline-block !important;
                text-align: left !important;
            }

            .two-column .content-right {
                text-align: left !important
            }

            .product-left {
                display: block !important;
                width: 100% !important;
            }

            .product-right {
                display: block !important;
                width: 100% !important;
                text-align: left !important;
            }

            .product-right tbody {
                display: block !important;
                text-align: left !important
            }

            .product-space {
                display: none !important
            }

            .col-1,
            .col-2 {
                display: inline-block !important;
                width: 100% !important;
                padding-left: 15px !important
            }

            .col-2 {
                padding-top: 10px !important;
                text-align: left !important;
            }
        }
    </style>
</head>

<body style="background:#fff; padding:0; margin:0px;">
    <center class="wrapper">
        <div class="container">
            <table bgcolor="#f8f9fa" align="center" border="0" cellspacing="0" cellpadding="0"
                style="font-family:'Montserrat', Arial, Helvetica, sans-serif;font-size:14px;line-height:18px;background:#f8f9fa; color:#1d1d1d; font-weight:600"
                class="outer">
                <tr>
                    <td>
                        <!--main table-->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="left" valign="top">
                                    <!--Banner-->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td><img src="http://nopguru.com/email/order-cancelled-banner.png"
                                                    style="max-width:100%; height:auto" width="595" height="281"
                                                    alt="" /></td>
                                        </tr>
                                    </table>
                                    <!--Banner-->
                                </td>
                            </tr>
                            <tr>
                                <td align="left" valign="top" class="padding">
                                    <!--welcome section-->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                        <tr>
                                            <td height="25">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td><img src="http://nopguru.com/email/sippy-logo.png" width="108"
                                                    height="38" alt="" /></td>
                                        </tr>
                                        <tr>
                                            <td height="20">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:28px; color:#2c2c2c"><img
                                                    src="http://nopguru.com/email/order-cancelled.png" width="219"
                                                    height="33" alt="" /></td>
                                        </tr>
                                        <tr>
                                            <td height="15">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Hey {{ $order->user->first_name }},</strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <!--pera-->
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                                    style="font-size:14px;" class="pera">
                                                    <tr>
                                                        <td class="pera" style="color:#5c5c5c; line-height:22px;">
                                                            Item(s) from your order were cancelled. A refund will be
                                                            issued to you immediately and should reflect in your account
                                                            in 3 business days.</td>
                                                    </tr>
                                                </table>

                                                <!--pera-->
                                            </td>
                                        </tr>
                                    </table>

                                    <!--welcome section-->
                                </td>
                            </tr>
                            <tr>
                                <td align="left" valign="top" height="20">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" style="background-color:#f2f2f2" class="padding">
                                    <!--two column-->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class="two-column">
                                                <table border="0" align="center" cellpadding="0" cellspacing="0"
                                                    class="column">
                                                    <tr>
                                                        <td align="right">
                                                            <table class="content">
                                                                <tr>
                                                                    <td>
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td style="font-size:14px"><strong>Order
                                                                                        #{{ $order->order_number }}</strong></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td height="5"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-size:14px">
                                                                                    <strong>Shipping Address</strong>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-size:12px"><strong>{{ $order->user->name }}</strong></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-size:12px">
                                                                                    <strong>{{ $order->address->title }}</strong></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-size:12px">
                                                                                    {{ $order->address->address_line_1 .' ' . $order->address->address_line_2 }}
                                                                                    <br>
                                                                                    {{ $order->address->city()->first()->name ?? '' }},{{ $order->address->country()->first()->country_name ?? '' }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-size:12px">{{ $order->user->country_code .' ' . $order->user->phone }}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <img src="http://nopguru.com/email/1px.png" style="max-width:100%; height:auto" alt="" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table border="0" cellspacing="0" cellpadding="0" class="column">
                                                    <tr>
                                                        <td align="left">
                                                            <table class="content content-right">
                                                                <tr>
                                                                    <td valign="middle">
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="align-left" align="left">
                                                                            <tr>
                                                                                <td>&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td height="5"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-size:14px">
                                                                                    <strong>Payment Method</strong>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-left" style="font-size:12px">
                                                                                    @if(strtolower($order->payment_type) == 'card')
                                                                                    <img src="{{ asset('assets/images/' . $order->card_type .'.png') }}" width="25" height="15" alt="" />
                                                                                    **** {{ $order->card_number }}
                                                                                    @else
                                                                                    Cash On Delivery
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-left"><strong>Order
                                                                                        Date</strong></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="align-left" style="font-size:12px">
                                                                                    {{ $order->created_at->timezone($app_settings['timezone'] ?? 'UTC')->format("M d, Y") }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>&nbsp;</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><img src="http://nopguru.com/email/1px.png" style="max-width:100%; height:auto" alt="" /> </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--tow column-->
                                </td>
                            </tr>
                            <tr>
                                <td align="left" height="25" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="left" valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class="padding"><strong>Order Details</strong></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            @foreach ($order->details as $item)
                                            @if (!empty($detail_ids) && !in_array($item->id, $detail_ids))
                                                @php
                                                    continue;
                                                @endphp
                                            @endif
                                            <tr>
                                                <td width="25"> <img src="https://d250wtlu7i24bo.cloudfront.net/emailtemplateassets/img/empty.gif" width="1"
                                                        height="14" style="display: block; height: 14px;width: 15px" alt=""> </td>
                                                <td align="center" valign="top" style="border-bottom:1px #e4e5e6 solid">
                                                    <div style="display: block; font-size: 0pt; line-height: 0pt; height: 14px;">
                                                        <img src="https://d250wtlu7i24bo.cloudfront.net/emailtemplateassets/img/empty.gif" width="1" height="14"
                                                            style="display: block; height: 14px;" alt=""> </div>



                                                    @if (!empty($item->subscription_id))
                                                    <img src="{{ $item->subscription->image_url ?? '' }}" width="56" height="80" alt="" style="width:auto" />
                                                    @elseif (!empty($item->equipment_id))
                                                    <img src="{{ $item->equipment->images[0]->image_path ?? '' }}" width="56" height="80" alt=""
                                                        style="width:auto" />
                                                    @else
                                                    <img src="{{ $item->product->images[0]->image_path ?? '' }}" width="56" height="80" alt=""
                                                        style="width:auto" />
                                                    @endif

                                                    <div style="display: block; font-size: 0pt; line-height: 0pt; height: 14px;">
                                                        <img src="https://d250wtlu7i24bo.cloudfront.net/emailtemplateassets/img/empty.gif" width="1" height="14"
                                                            style="display: block; height: 14px;" alt=""> </div>
                                                </td>
                                                <td valign="middle" align="left" style="border-bottom:1px #e4e5e6 solid">
                                                    <div style="display: block; font-size: 0pt; line-height: 0pt; height: 14px;">
                                                        <img src="https://d250wtlu7i24bo.cloudfront.net/emailtemplateassets/img/empty.gif" width="1" height="14"
                                                            style="display: block; height: 14px;" alt=""> </div>
                                                    <div style="width: 100%;display: block;">
                                                        <div class="col-1" style="width: 65%;display: inline-block;vertical-align: middle;">
                                                            <div class="product-type" style="color:#ed3f27; font-size:12px;">
                                                                @if (!empty($item->subscription_id))
                                                                SIPPY
                                                                @elseif (!empty($item->equipment_id))
                                                                {{ $item->equipment->brand->title }}
                                                                @else
                                                                {{ $item->product->brand->name }}
                                                                @endif
                                                            </div>
                                                            <div class="product-name" style="font-size:18px; color:#1d1d1d;">
                                                                @if (!empty($item->subscription_id))
                                                                {{ $item->subscription->title }}
                                                                @elseif (!empty($item->equipment_id))
                                                                {{ $item->equipment->title }}
                                                                @else
                                                                {{ $item->product->product_name }}
                                                                @endif
                                                            </div>
                                                            <div class="product-size" style="font-size:12px; color:#848484; padding-top:5px;">
                                                                @if (!empty($item->product_id) && !empty($item->variant_id))
                                                                {{ $item->variant->title }} -
                                                                @endif
                                                                {{ $item->grind_title }}
                                                            </div>
                                                        </div>
                                                        <div class="col-2" style="width: 33%;display: inline-block;vertical-align: middle;text-align: right;">
                                                            <div class="product-price" style="font-size:18px; color:#1d1d1d;">
                                                                {{ ($app_settings['currency_code'] ?? 'AED') .' '. number_format($item->amount,2) }}</div>
                                                            <div class="product-qty">Qty: {{ $item->quantity }}</div>
                                                        </div>
                                                    </div>
                                                    <div style="display: block; font-size: 0pt; line-height: 0pt; height: 14px;width: 100%;float: left;">
                                                        <img src="https://d250wtlu7i24bo.cloudfront.net/emailtemplateassets/img/empty.gif" width="1" height="14"
                                                            style="display: block; height: 14px;" alt=""> </div>
                                                </td>

                                                <td width="15"> <img src="https://d250wtlu7i24bo.cloudfront.net/emailtemplateassets/img/empty.gif" width="1"
                                                        height="14" style="display: block; height: 14px;width: 15px" alt=""> </td>
                                            </tr>
                                            @endforeach

                                            {{-- <tr>
                                                                                        <td width="25"> <img
                                                                                                src="https://d250wtlu7i24bo.cloudfront.net/emailtemplateassets/img/empty.gif"
                                                                                                width="1" height="14"
                                                                                                style="display: block; height: 14px;width: 25px" alt=""> </td>
                                                                                        <td align="center" valign="top" style="border-bottom:1px #e4e5e6 solid">
                                                                                            <div
                                                                                                style="display: block; font-size: 0pt; line-height: 0pt; height: 14px;">
                                                                                                <img src="https://d250wtlu7i24bo.cloudfront.net/emailtemplateassets/img/empty.gif"
                                                                                                    width="1" height="14" style="display: block; height: 14px;"
                                                                                                    alt=""> </div>
                                                                                            <img src="http://nopguru.com/email/product-2.jpg" width="56"
                                                                                                height="80" alt="" style="width:auto" />
                                                                                            <div
                                                                                                style="display: block; font-size: 0pt; line-height: 0pt; height: 14px;">
                                                                                                <img src="https://d250wtlu7i24bo.cloudfront.net/emailtemplateassets/img/empty.gif"
                                                                                                    width="1" height="14" style="display: block; height: 14px;"
                                                                                                    alt=""> </div>
                                                                                        </td>
                                                                                        <td valign="middle" align="left"
                                                                                            style="border-bottom:1px #e4e5e6 solid">
                                                                                            <div
                                                                                                style="display: block; font-size: 0pt; line-height: 0pt; height: 14px;">
                                                                                                <img src="https://d250wtlu7i24bo.cloudfront.net/emailtemplateassets/img/empty.gif"
                                                                                                    width="1" height="14" style="display: block; height: 14px;"
                                                                                                    alt=""> </div>
                                                                                            <div style="width: 100%;display: block;">
                                                                                                <div class="col-1"
                                                                                                    style="width: 65%;display: inline-block;vertical-align: middle;">
                                                                                                    <div class="product-type"
                                                                                                        style="color:#ed3f27; font-size:12px;">Three Coffee
                                                                                                    </div>
                                                                                                    <div class="product-name"
                                                                                                        style="font-size:18px; color:#1d1d1d;">Hondura Los Piños
                                                                                                    </div>
                                                                                                    <div class="product-size"
                                                                                                        style="font-size:12px; color:#848484; padding-top:5px;">
                                                                                                        250g Bag | Whole Bean</div>
                                                                                                </div>
                                                                                                <div class="col-2"
                                                                                                    style="width: 33%;display: inline-block;vertical-align: middle;text-align: right;">
                                                                                                    <div class="product-price"
                                                                                                        style="font-size:18px; color:#1d1d1d;">AED 250.00</div>
                                                                                                    <div class="product-qty">Qty: 1</div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div
                                                                                                style="display: block; font-size: 0pt; line-height: 0pt; height: 14px;width: 100%;float: left;">
                                                                                                <img src="https://d250wtlu7i24bo.cloudfront.net/emailtemplateassets/img/empty.gif"
                                                                                                    width="1" height="14" style="display: block; height: 14px;"
                                                                                                    alt=""> </div>
                                                                                        </td>

                                                                                        <td width="25"> <img
                                                                                                src="https://d250wtlu7i24bo.cloudfront.net/emailtemplateassets/img/empty.gif"
                                                                                                width="1" height="14"
                                                                                                style="display: block; height: 14px;width: 25px" alt=""> </td>
                                                                                    </tr> --}}
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class="padding">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                                    class="product-wrapper">
                                                    <!--product item-->
                                                    <tr>
                                                        <td align="right">
                                                            <table width="65%" border="0" cellspacing="0"
                                                                cellpadding="0">
                                                                <tr>
                                                                    <td height="1"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="height:15px; font-size:0; line-height:none">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height:24px;">
                                                                            <tr>
                                                                                <td align="left" valign="top">Item
                                                                                    Total(s)</td>
                                                                                <td align="right" valign="top">
                                                                                    {{ $app_settings['currency_code'] ?? 'AED' }} {{ number_format($order->cart_total, 2) }}

                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left" valign="top">Delivery
                                                                                    Fee</td>
                                                                                <td align="right" valign="top">
                                                                                    {{ $order->delivery_fee > 0 ? $app_settings['currency_code'] ?? 'AED ' . number_format($order->delivery_fee, 2) : 'Free' }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left" valign="top">Discount
                                                                                </td>
                                                                                <td align="right" valign="top">{{ $app_settings['currency_code'] ?? 'AED' }}
                                                                                    {{ number_format($order->total_discount, 2) }}
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="height:10px; font-size:0; line-height:none">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="1" style="border-top:1px #e4e5e6 solid">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="height:10px; font-size:0; line-height:none">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height:24px;">
                                                                            <tr>
                                                                                <td align="left" valign="top">Subtotal
                                                                                </td>
                                                                                <td align="right" valign="top">
                                                                                <td align="right" valign="top">{{ $app_settings['currency_code'] ?? 'AED' }}
                                                                                    {{ number_format($order->subtotal, 2) }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left" valign="top">Taxes
                                                                                    &amp; Charges</td>
                                                                                <td align="right" valign="top">
                                                                                <td align="right" valign="top">{{ $app_settings['currency_code'] ?? 'AED' }}
                                                                                    {{ number_format($order->tax_charges, 2) }}
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="height:10px; font-size:0; line-height:none">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="1" style="border-top:3px #e4e5e6 solid">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="height:10px; font-size:0; line-height:none">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td align="left" valign="top"><strong style="font-weight:800">Total
                                                                                        Amount</strong></td>
                                                                                <td align="right" valign="top"><strong style="font-weight:800">
                                                                                <td align="right" valign="top">{{ $app_settings['currency_code'] ?? 'AED' }}
                                                                                    {{ number_format($order->total_amount, 2) }}</strong></td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" height="25" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="left" height="30" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="center" valign="top"><img
                                                    src="http://nopguru.com/email/sippy-logo.png" width="108"
                                                    height="38" alt="" /></td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top"><a href="http://www.hypeten.com/"
                                                    target="_blank"
                                                    style="color:#1d1d1d; font-size:10px; text-decoration:none">www.hypeten.com</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="110" border="0" cellspacing="0" cellpadding="0"
                                                    align="center">
                                                    <tr>
                                                        <td align="center"><a href="#"><img
                                                                    src="http://nopguru.com/email/instagram-icon.png"
                                                                    width="18" height="18" alt="" /></a></td>
                                                        <td align="center"><a href="#"><img
                                                                    src="http://nopguru.com/email/facebook-icon.png"
                                                                    width="9" height="18" alt="" /></a></td>
                                                        <td align="center"><a href="#"><img
                                                                    src="http://nopguru.com/email/twitter-icon.png"
                                                                    width="21" height="18" alt="" /></a> </td>
                                                    </tr>
                                                </table>




                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" height="20" valign="top">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="300" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td height="5" style="border-top:2px #f3f3f3 solid"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="font-size:11px; color:#848484">If you
                                                have any questions or concerns please contact us at: <br />
                                                <a href="mailto:hello@hypeten.com"
                                                    style="color:#f53e22; text-decoration:none">hello@hypeten.com</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" height="10" valign="top"></td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="color:#c7c7c7; font-size:10px">
                                                <strong style="color:#767676;">SIPPY LTD</strong>, 1 Sheikh Mohammed bin
                                                Rashid Blvd, Burj Khalifa, Apt 1206 Dubai, UAE</td>
                                        </tr>
                                        <tr>
                                            <td align="center" height="10" valign="top"></td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                        style="background:#f3f3f3">
                                        <tr>
                                            <td style="padding:10px;">
                                                <table width="90%" border="0" cellspacing="0" cellpadding="0"
                                                    align="center">
                                                    <tr>
                                                        <td align="left" valign="middle" width="50%"
                                                            style="font-size:10px; color:#a4a4a4">©2020 SIPPY LTD, All
                                                            Rights Reserved</td>
                                                        <td align="right" valign="middle"
                                                            style="font-size:10px; color:#a4a4a4"><a href="#"
                                                                style="color:#a4a4a4; text-decoration:none">Privacy
                                                                Policy</a> | <a href="#"
                                                                style="color:#a4a4a4; text-decoration:none">Terms &
                                                                Conditions</a> | <a href="#"
                                                                style="color:#a4a4a4; text-decoration:none">Returns</a>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!--End main table-->
                    </td>
                </tr>
            </table>
        </div>
    </center>
</body>

</html>
