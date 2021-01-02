<?php

namespace App\Exports;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromQuery, WithHeadings, WithMapping
{
    public function headings(): array
    {
        return [
            'User No',
            'First Name',
            'Last Name',
            'Email Address',
            'Phone Number',
            'Reward Points',
            'Orders',
            'Revenue',
            'Created At'
        ];
    }

    public function query()
    {
        $users = User::query()->selectRaw('id,first_name,last_name,email,phone,created_at')->whereStatus(1)->where('user_type', '!=', 'admin')->withCount('orders');
        if (!empty(request()->input('user_ids'))) {
            $user_ids = request()->input('user_ids');
            if(gettype($user_ids) === 'string') {
                $user_ids = explode(',', $user_ids);
            }
            $users = $users->whereIn('id', $user_ids);
        }
        return $users;
    }

    public function map($user): array
    {
        $app_settings = config('app_settings');
        $user->created_at = Carbon::parse($user->created_at)->timezone($app_settings['timezone'])->format("M d,Y g:iA");

        return [
            'User No' => $user->id,
            'First Name' => $user->first_name,
            'Lats Name' => $user->last_name,
            'Email Address' => $user->email,
            'Phone Number' => $user->phone,
            'Reward Points'  => !empty($user->reward_points) ? $user->reward_points : '0',
            'Orders'  => !empty($user->orders_count) ? $user->orders_count : '0',
            'Revenue'  => ($app_settings['currency_code'] ?? '') . ' ' . $user->revenue,
            'Created At' => $user->created_at,
        ];
    }
}
