<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Grind;
use Illuminate\Http\Request;
use App\Models\SubscriptionProduct;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $subscriptions = Subscription::select('*')->orderBy('id', 'asc')->get();
        view()->share('page_title', 'Subscription');
        return view('admin.subscription.list', compact('subscriptions'));
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
}
