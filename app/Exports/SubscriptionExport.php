<?php

namespace App\Exports;

use App\Models\UserSubscription;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubscriptionExport implements FromQuery, WithHeadings, WithMapping
{
    public function headings(): array
    {
        return [
            'Order No',
            'Customer',
            'Email',
            'Start Date',
            'End Date',
            'Next Billing On',
            'Subscription Status',
            'Cart Total',
            'Delivery Fee',
            'Subtotal',
            'Tax & Charges',
            'Total Amount'
        ];
    }

    public function query()
    {
        $subscriptions = UserSubscription::selectRaw('user_subscriptions.*,
                        order_number, cart_total, delivery_fee, subtotal, tax_charges, total_amount,
                        name, email')
                        ->leftJoin('users', 'user_subscriptions.user_id', 'users.id')
                        ->leftJoin('orders', 'user_subscriptions.order_id', 'orders.id')
                        ->where('user_type', '!=', 'admin')
                        ->orderBy('id', 'DESC');
        if (!empty(request()->input('user_ids'))) {
            $subscriptions = $subscriptions->where('user_subscriptions.user_id', request()->input('user_ids'));
        }
        if (!empty(request()->input('status'))) {
            $subscriptions = $subscriptions->whereHas('subscriptions.subscription_status', request()->input('status'));
        }
        $subscriptions = $subscriptions->with('lastSubscription');
        return $subscriptions;
    }

    public function map($subscription): array
    {
        $app_settings = config('app_settings');
        $nextBillingDate = '-';
        if (($subscription->lastSubscription->subscription_status ?? 0) == '1') {
            $nextBillingDate = Carbon::parse($subscription->lastSubscription->billing_date)->addMonth()->timezone($app_settings['timezone'])->format("M d, Y");
        }

        return [
            'Order No' => $subscription->order_number ?? '-',
            'Customer' => $subscription->name ?? '-',
            'Email' => $subscription->email ?? '-',
            'Start Date' => Carbon::parse($subscription->start_date)->timezone($app_settings['timezone'])->format("M d, Y"),
            'End Date' => Carbon::parse($subscription->end_date)->timezone($app_settings['timezone'])->format("M d, Y"),
            'Next Billing On' => $nextBillingDate,
            'Subscription Status' => (($subscription->lastSubscription->subscription_status ?? 0) == '1' ? 'Active' : 'Inactive'),
            'Cart Total' => $app_settings['currency_code'] .' '. $subscription->cart_total,
            'Delivery Fee' => $app_settings['currency_code'] .' '. $subscription->delivery_fee,
            'Subtotal' => $app_settings['currency_code'] .' '. $subscription->subtotal,
            'Tax & Charges' => $app_settings['currency_code'] .' '. $subscription->tax_charges,
            'Total Amount' => $app_settings['currency_code'] .' '. $subscription->total_amount
        ];
    }
}
