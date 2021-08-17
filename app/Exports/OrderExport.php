<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromQuery, WithHeadings, WithMapping
{
    public function headings(): array
    {
        return [
            'Order No.',
            'Customer',
            'Order Items',
            'Status',
            'Item Total',
            'Delivery Fee',
            'Discount',
            'Subtotal',
            'Taxes & Charges',
            'Total',
            'Reward Points',
            'Order Date'
        ];
    }

    public function query()
    {
        $orders = Order::query()
                    ->selectRaw('id,order_type,order_number,(select name from users where id = orders.user_id) customer_name,
                        cart_total,delivery_fee,discount_type,discount_amount,promocode_amount,subtotal,tax_charges,
                        total_amount,reward_points,created_at')
                    ->with(["details", "details.product", "details.equipment", "details.subscription"]);

        if (!empty(request()->input('user_id'))) {
            $user_id = request()->input('user_id');
            $orders = $orders->where('user_id', $user_id);
        }
        if (!empty(request()->input('status'))) {
            $status = request()->input('status');
            $orders = $orders->where('status', $status);
        }
        if (!empty(request()->input('start_date'))) {
            $start_date = request()->input('start_date');
            $orders = $orders->whereRaw('DATE(created_at) >= ' . $start_date);
        }
        if (!empty(request()->input('end_date'))) {
            $end_date = request()->input('end_date');
            $orders = $orders->whereRaw('DATE(created_at) <= ' . $end_date);
        }
        return $orders;
    }

    public function map($order): array
    {
        $app_settings = config('app_settings');
        $order->created_at = Carbon::parse($order->created_at)->timezone($app_settings['timezone'])->format("M d,Y g:iA");

        $order->total_discount = $order->promocode_amount ?? 0;
        if (!empty($order->discount_type) && !empty($order->discount_amount)) {
            $discount_amount = ($order->discount_type == 'percentage' ? (($order->total_amount / 100) * $order->discount_amount) : $order->discount_amount);
            $order->total_discount = $order->total_discount + $discount_amount;
        }

        $product_names = null;
        if ($order->order_type == 'subscription') {
            $product_names = "SIPPY - " . ($order->subscription->title ?? '') . ' x1';
        }
        else {
            foreach ($order->details as $detail) {
                if (!empty($detail->product) && isset($detail->product->product_name)) {
                    $name = ($detail->product->brand->name ?? '') . ' - ' . $detail->product->product_name . ' x' . $detail->quantity;
                    $product_names .= (!empty($product_names) ? ', ' : '') . $name;
                }
            }

            foreach ($order->details as $detail) {
                if (!empty($detail->equipment) && isset($detail->equipment->title)) {
                    $name = ($detail->equipment->brand->name ?? '') . ' - ' . $detail->equipment->title . ' x' . $detail->quantity;
                    $product_names .= (!empty($product_names) ? ', ' : '') . $name;
                }
            }
        }
        /* if (!empty($product_names) && strlen($product_names) >= 40) {
            $product_names = substr($product_names, 0, 37) . '...';
        } */
        return [
            'Order No' => $order->order_number,
            'Customer' => $order->customer_name ?? '-',
            'Order Items' => $product_names,
            'Status' => $order->status_text,
            'Item Total' => $app_settings['currency_code'] .' '. $order->cart_total,
            'Delivery Fee' => $app_settings['currency_code'] . ' ' . $order->delivery_fee,
            'Discount' => $app_settings['currency_code'] . ' ' . $order->total_discount,
            'Subtotal' => $app_settings['currency_code'] . ' ' . $order->subtotal,
            'Taxes & Charges' => $app_settings['currency_code'] . ' ' . $order->tax_charges,
            'Total' => $app_settings['currency_code'] . ' ' . $order->total_amount,
            'Reward Points'  => $order->reward_points,
            'Order Date'  => $order->created_at
        ];
    }
}
