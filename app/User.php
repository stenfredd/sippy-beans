<?php

namespace App;

use App\Models\Order;
use App\UserReward;
use App\Models\UserAddress;
use App\Models\UserSubscription;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use Stripe\StripeClient;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'name',
        'profile_image', 'email',
        'country_code', 'phone',
        'device_type', 'device_token',
        'password',
        'social_login', 'apple_id', 'google_id', 'stripe_id',
        'status', 'user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'reward_points',
        'revenue',
        'status_text'
    ];

    public function getRewardPointsAttribute()
    {
        $user_id = auth('api')->user()->id ?? ($this->id ?? 0);
        $total_credit_reward = UserReward::whereRewardType('credit')->whereUserId($user_id)->sum('reward_points');
        $total_withdraw_reward = UserReward::whereRewardType('withdraw')->whereUserId($user_id)->sum('reward_points');
        $reward_points = $total_credit_reward - $total_withdraw_reward;
        return $reward_points;
    }

    public function getRevenueAttribute()
    {
        return number_format(Order::whereUserId($this->id ?? 0)->sum('total_amount'), 2) ?? 0;
    }

    public function getStatusTextAttribute()
    {
        return ($this->attributes['status'] ?? 0) == 1 ? 'Active' : 'Inactive';
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class, 'user_id', 'id');
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class, 'user_id', 'id');
    }

    public function lastSubscription()
    {
        return $this->hasOne(UserSubscription::class, 'user_id', 'id')->orderBy('id', 'desc');
    }

    protected static function booted()
    {
        static::created(function ($user) {
            try {
                if ($user->user_type !== 'admin') {
                    $app_settings = config("app_settings");
                    $stripe = new StripeClient(env("STRIPE_SECRET", $app_settings['stripe_secret_key']));
                    $customers = $stripe->customers->all();
                    if (isset($customers['data']) && !empty($customers['data'])) {
                        $customer_emails = array_column($customers['data'], 'email');
                        if (in_array($user->email, $customer_emails)) {
                            $key = array_search($user->email, $customer_emails);
                            $customer = $customers['data'][$key];
                            $user->stripe_id = $customer->id;
                        }
                        else {
                            $customer = $stripe->customers->create([
                                'name' => $user->name,
                                'phone' => $user->phone,
                                'email' => $user->email
                            ]);
                            $user->stripe_id = $customer->id;
                        }
                        $user->save();
                    }
                    else {
                        $customer = $stripe->customers->create([
                            'name' => $user->name,
                            'phone' => $user->phone,
                            'email' => $user->email
                        ]);
                        $user->stripe_id = $customer->id;
                        $user->save();
                    }
                }
            }
            catch(\Exception $e) {
                info("Stripe error: " . $e->getMessage());
                $user->delete();
                return response()->json(['status' => false, 'message' => 'Something went wrong, Please try again']);
            }
        });
    }
}
