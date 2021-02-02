<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SubscriptionExport;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Grind;
use Illuminate\Http\Request;
use App\Models\SubscriptionProduct;
use App\Models\UserSubscription;
use App\User;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $subscriptions = Subscription::select('*')->orderBy('id', 'asc')->get();
        $total_active_subscription = UserSubscription::selectRaw('DISTINCT user_id')->whereSubscriptionStatus(1)->groupBy('user_id')->get();
        $total_active_subscription = count($total_active_subscription);
        view()->share('page_title', 'Subscription');
        return view('admin.subscription.list', compact('subscriptions', 'total_active_subscription'));
    }

    public function save(Request $request)
    {
        $validation = [
            'status' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required'
        ];
        $this->validate($request, $validation);

        $request_data = $request->except('image_url');
        if ($request->hasFile('image_url')) {
            $image_file = $request->file('image_url');
            $imageName = time() . '.' . $image_file->extension();
            $image_file->move(public_path('uploads/subscriptions'), $imageName);
            $request_data['image_url'] = asset('uploads/subscriptions/' . $imageName);
        }
        $request_data['status'] = isset($request_data['status']) ? $request_data['status'] : 0;
        if (isset($request_data['grind_ids']) && !empty($request_data['grind_ids'])) {
            $request_data['grind_ids'] = implode(',', $request_data['grind_ids']);
        }
        if (isset($request_data['subscription_id']) && !empty($request_data['subscription_id'])) {
            $subscription = Subscription::find($request_data['subscription_id'])->update($request_data);
            $subscription_id = $request_data['subscription_id'];
        } else {
            $subscription = Subscription::create($request_data);
            $subscription_id = $subscription->id;
        }

        $msg = isset($request_data['subscription_id']) && !empty($request_data['subscription_id']) ? 'updated' : 'created';
        $msg1 = isset($request_data['subscription_id']) && !empty($request_data['subscription_id']) ? 'Updating' : 'Creating';
        if ($subscription) {
            session()->flash('success', 'Subscription details ' . $msg . ' successfully.');
            return redirect(url('admin/subscription/' . $subscription_id));
        } else {
            session()->flash('error', $msg1 . ' subscription details failed, Please try again.');
            return redirect()->back();
        }
    }

    public function show(Request $request, $id = null)
    {
        $subscription = Subscription::find($id);
        $grinds = Grind::all();
        view()->share('page_title', (!empty($id) && is_numeric($id) ? 'Update Subscription' : 'Add New Subscription'));
        return view('admin.subscription.show', compact('subscription', 'grinds'));
    }

    public function subscribedCustomers(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select('id', 'name', 'email')->where('user_type', '!=', 'admin')->orderBy('id', 'DESC');
            if (!empty($request->input('search'))) {
                $users = $users->where(function ($query) use ($request) {
                    $query->where('first_name', 'LIKE', "%" . $request->search . "%");
                    $query->orWhere('last_name', 'LIKE', "%" . $request->search . "%");
                    $query->orWhere('email', 'LIKE', "%" . $request->search . "%");
                    $query->orWhere('phone', 'LIKE', "%" . $request->search . "%");
                });
            }
            $users = $users->withCount('subscriptions')->with('lastSubscription')->get();

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('subscription_status', function ($user) {
                    return $user->lastSubscription->subscription_status ?? '0';
                })
                ->addColumn('subscription_status_text', function ($user) {
                    return ($user->lastSubscription->subscription_status ?? 0) == '1' ? 'Active' : 'Inactive';
                })
                /* ->addColumn("pause_subscription", function ($user) {
                    $action = '<div class="custom-control custom-switch custom-switch-primary mr-2 mb-1 text-center">
                    <input class="custom-control-input" type="checkbox" id="sub-status'.($user->id).'"
                         '.(($user->lastSubscription->subscription_status ?? 0) == 1 ? 'checked' : '') .'
                            onchange="pauseSubscription('.($user->lastSubscription->id ?? 0).')"
                            '.(($user->lastSubscription->subscription_status ?? 0) == 0 ? 'disabled' : '').'/>
                    <label class="custom-control-label" for="sub-status-'.($user->id).'">
                    <span class="switch-text-left"></span>
                    <span class="switch-text-right"></span>
                    </label>
                 </div>';
                    return $action;
                }) */
                ->addColumn('pause_subscription', function ($user) {
                    $action = '<div class="custom-control custom-switch custom-switch-primary mr-2 mb-1 text-center">
                    <input type="checkbox" class="custom-control-input"
                        ' . (($user->lastSubscription->subscription_status ?? 0) == 1 ? 'checked' : '') . '
                        ' . (($user->lastSubscription->subscription_status ?? 0) == 0 ? 'disabled' : '') . '
                        id="user-status-' . ($user->id ?? 0) . '"
                        onchange="pauseSubscription(' . ($user->lastSubscription->id ?? 0) . ', '.($user->id).')"/>
                    <label class="custom-control-label" for="user-status-' . $user->id . '">
                    <span class="switch-text-left"></span>
                    <span class="switch-text-right"></span>
                    </label>
                 </div>';
                    return $action;
                })
                ->addColumn('next_billing_date', function ($user) {
                    $nextBillingDate = '-';
                    if (($user->lastSubscription->subscription_status ?? 0) == '1') {
                        $nextBillingDate = Carbon::parse($user->lastSubscription->billing_date)->timezone($this->app_settings['timezone'])->format("M d, Y");
                    }
                    return $nextBillingDate;
                })
                ->editColumn('created_at', function ($user) {
                    $date = Carbon::parse($user->created_at)->timezone($this->app_settings['timezone'])->format("M d,Y");
                    $time = Carbon::parse($user->created_at)->timezone($this->app_settings['timezone'])->format("g:iA");
                    return $date . '<br><span class="time">' . $time . '</span>';
                })
                ->addColumn('action', function ($user) {
                    $action = '<a href="' . url('admin/users/' . $user->id) . '" href="' . url('admin/users/' . $user->id) . '"><i class="feather icon-eye"></i></a>';
                    return $action;
                })
                ->rawColumns(['pause_subscription', 'action', 'created_at'])
                ->make(TRUE);
        }
    }

    public function export()
    {
        return \Excel::download(new SubscriptionExport, 'subscriptionData.xlsx');
    }

    public function pauseSubscription(Request $request) {
        if($request->ajax()) {
            $request->validate([
                'sub_id' => 'required'
            ]);

            $user_subscription = UserSubscription::find($request->sub_id);
            try {
                $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET", $this->app_settings['stripe_secret_key']));
                $stripe->subscriptions->cancel(
                    $user_subscription->stripe_subscription_id,
                    []
                );
                $user_subscription->cancelled_at = date("Y-m-d H:i:s");
                $user_subscription->save();
                return response()->json(['status' => true, 'message' => 'Subscription cancelled successfully.']);
            }
            catch (\Exception $e) {
                info("Subscription cancel error - " . $e->getMessage());
                return response()->json(['status' => false, 'message' => 'Something went wrong, Please try again.']);
            }
        }
    }
}
