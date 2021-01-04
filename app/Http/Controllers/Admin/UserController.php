<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MatchMakers;
use App\Models\Order;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Exports\UserExport;
use App\UserReward;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::select('*')->where('user_type', '!=', 'admin')->orderBy('id', 'DESC');
        if ($request->ajax()) {
            if (!empty($request->input('search'))) {
                $users = $users->where(function ($query) use ($request) {
                    $query->where('first_name', 'LIKE', "%" . $request->search . "%");
                    $query->orWhere('last_name', 'LIKE', "%" . $request->search . "%");
                    $query->orWhere('email', 'LIKE', "%" . $request->search . "%");
                    $query->orWhere('phone', 'LIKE', "%" . $request->search . "%");
                });
            }
            $users = $users->withCount('orders')->get();

            return DataTables::of($users)
                ->addIndexColumn()
                ->editColumn('profile_image', function ($user) {
                    return '<img src="' . ($user->profile_image ? asset($user->profile_image) : asset('images/logo/favicon.ico')) . '" class="img-thumbnail" style="height: 100px; width: 100px;"/>';
                })
                ->editColumn('revenue', function ($user) {
                    return number_format(Order::whereUserId($user->id)->sum('total_amount'), 2);
                })
                ->editColumn('reward_points', function ($user) {
                    $total_credit_reward = UserReward::whereRewardType('credit')->whereUserId($user->id)->sum('reward_points');
                    $total_withdraw_reward = UserReward::whereRewardType('withdraw')->whereUserId($user->id)->sum('reward_points');
                    return $total_credit_reward - $total_withdraw_reward;;
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
                ->rawColumns(['profile_image', 'action', 'created_at'])
                ->make(TRUE);
        }
        $total_users = $users->count();
        $page_title = 'Users';
        view()->share('page_title', $page_title);
        return view('admin.users.list', compact('total_users'));
    }

    public function save(Request $request)
    {
        $validation = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ];
        if (!isset($request->user_id) || empty($request->user_id)) {
            $validation['email'] = 'required|email|unique:users';
        }
        $this->validate($request, $validation);

        $request_data = $request->except('profile_image');
        $request_data['name'] = $request_data['first_name'] . ' ' . $request_data['last_name'];

        if ($request->hasFile('profile_image')) {
            $image_file = $request->file('profile_image');
            $imageName = time() . '.' . $image_file->extension();
            $image_file->move(public_path('uploads/users'), $imageName);
            $request_data['profile_image'] = asset('uploads/users/' . $imageName);
        }

        if (!isset($request_data['user_id']) || empty($request_data['user_id'])) {
            $request_data['password'] = Hash::make($request_data['password'] ?? env('DEFAULT_PASS'));
            $request_data['status'] = 1;
            $request_data['email_verified_at'] = date("Y-m-d H:i:s");
        }

        if (isset($request_data['user_id']) && !empty($request_data['user_id'])) {
            $user = User::find($request_data['user_id'])->update($request_data);
        } else {
            $user = User::create($request_data);
        }
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($user) {
            $msg = isset($request_data['user_id']) && !empty($request_data['user_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'User ' . $msg . ' successfully.'];
        }
        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $validation = [
            'user_id' => 'required'
        ];
        $request->validate($validation);

        $delete = User::destroy($request->user_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'User deleted successfully.'];
        }
        return response()->json($response);
    }

    public function show(Request $request)
    {
        $user_id = $request->route('id');
        $user = User::with(['addresses'])->findOrFail($user_id);

        $total_credit_reward = UserReward::whereRewardType('credit')->whereUserId($user_id)->sum('reward_points');
        $total_withdraw_reward = UserReward::whereRewardType('withdraw')->whereUserId($user_id)->sum('reward_points');
        $user->user_reward_points = $total_credit_reward - $total_withdraw_reward;
        $last_user_reward = UserReward::latest()->whereUserId($user_id)->first();

        $match_makers = MatchMakers::select('match_makers.*', 'user_match_makers.values')
            ->leftJoin('user_match_makers', function ($q) use ($user_id) {
                $q->on('match_makers.id', 'user_match_makers.match_maker_id');
                $q->where('user_id', $user_id);
            })
            ->where('match_makers.status', 1);
        $last_update_match = $match_makers;

        $match_makers = $match_makers->get();
        $last_update_match = $last_update_match->latest()->first()->created_at ?? null;

        if (!empty($match_makers) && count($match_makers) > 0) {
            foreach ($match_makers as $match_maker) {
                $match_maker->values_name = 'N/A';
                $match_maker_values = DB::table($match_maker->type . 's')->whereIn("id", explode(',', $match_maker->values))->get();
                if (!empty($match_maker_values) && count($match_maker_values) > 0 && isset($match_maker_values[0]->name)) {
                    $match_maker->values_name = implode(' | ', array_column($match_maker_values->toArray(), 'name'));
                }
                if (!empty($match_maker_values) && count($match_maker_values) > 0 && isset($match_maker_values[0]->title)) {
                    $match_maker->values_name = implode(' | ', array_column($match_maker_values->toArray(), 'title'));
                }
                if (!empty($match_maker_values) && count($match_maker_values) > 0 && isset($match_maker_values[0]->level_title)) {
                    $match_maker->values_name = implode(' | ', array_column($match_maker_values->toArray(), 'level_title'));
                }
            }
        }

        $new_orders = Order::whereStatus(0)->whereUserId($user->id)->count();
        $inprogress_orders = Order::whereStatus(1)->whereUserId($user->id)->count();
        $shipped_orders = Order::whereStatus(2)->whereUserId($user->id)->count();
        $completed_orders = Order::whereStatus(3)->whereUserId($user->id)->count();
        $cancelled_orders = Order::whereStatus(4)->whereUserId($user->id)->count();
        $all_orders = Order::whereUserId($user->id)->count();

        view()->share('page_title', 'User Profile');
        return view('admin.users.show', compact("user", 'match_makers', 'last_update_match', 'new_orders', 'inprogress_orders', 'shipped_orders', 'completed_orders', 'cancelled_orders', 'all_orders', 'last_user_reward'));
    }

    public function export(Request $request)
    {
        return \Excel::download(new UserExport, 'usersData.xlsx');
    }

    public function update(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'reward_points' => 'required'
        ]);

        $user = User::find($request->user_id);

        $total_credit_reward = UserReward::whereRewardType('credit')->whereUserId($user->id)->sum('reward_points');
        $total_withdraw_reward = UserReward::whereRewardType('withdraw')->whereUserId($user->id)->sum('reward_points');
        $user_reward_points = $total_credit_reward - $total_withdraw_reward;

        $type = null;
        $reward_points = null;

        if ($user_reward_points < $request->reward_points) {
            $type = 'credit';
            $reward_points = $request->reward_points - $user_reward_points;
        }
        if ($user_reward_points > $request->reward_points) {
            $type = 'withdraw';
            $reward_points = $user_reward_points - $request->reward_points;
        }
        $create = false;
        if (!empty($type) && !empty($reward_points)) {
            $create = UserReward::create([
                'user_id' => $request->user_id,
                'reward_type' => $type,
                'reward_points' => $reward_points
            ]);
        }

        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($create) {
            $response = ['status' => true, 'message' => 'User details updated successfully.'];
        }
        return response()->json($response);
    }
}
