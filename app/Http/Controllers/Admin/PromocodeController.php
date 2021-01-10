<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promocode;
use App\Models\UserPromocode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PromocodeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $promocodes = Promocode::select('*')->orderBy('id', 'desc');
            if (!empty($request->input('promo_type'))) {
                if ($request->promo_type == 1) {
                    $promocodes = $promocodes->where('start_date', '<=', date("Y-m-d H:i:s"))->where('end_date', '>=', date("Y-m-d H:i:s"));
                }
                if ($request->promo_type == 2) {
                    $promocodes = $promocodes->where('start_date', '>=', date("Y-m-d H:i:s"));
                }
                if ($request->promo_type == 3) {
                    $promocodes = $promocodes->where('end_date', '<=', date("Y-m-d H:i:s"));
                }
            }
            if (!empty($request->input('search'))) {
                $promocodes = $promocodes->where(function ($query) use ($request) {
                    $query->where('title', 'LIKE', "%" . $request->search . "%");
                    $query->orWhere('promocode_type', 'LIKE', "%" . $request->search . "%");
                    $query->orWhere('discount_type', 'LIKE', "%" . $request->search . "%");
                    $query->orWhere('discount_amount', 'LIKE', "%" . $request->search . "%");
                });
            }
            $promocodes = $promocodes->get();
            return DataTables::of($promocodes)
                ->addIndexColumn()
                ->editColumn('promocode_type', function ($promocode) {
                    return $promocode->promocode_type == 'all' ? 'For all users' : 'For selected user(s)';
                })
                ->editColumn('discount_type', function ($promocode) {
                    return ucfirst($promocode->discount_type);
                })
                ->editColumn('start_date', function ($promocode) {
                    return Carbon::parse($promocode->start_date)->timezone($this->app_settings['timezone'])->format("Y-m-d");
                })
                ->editColumn('end_date', function ($promocode) {
                    return Carbon::parse($promocode->end_date)->timezone($this->app_settings['timezone'])->format("Y-m-d");
                })
                ->addColumn('display_start_date', function ($promocode) {
                    return Carbon::parse($promocode->start_date)->timezone($this->app_settings['timezone'])->format("M d,Y") . '<br>' .
                        '<span class="gray">' . (Carbon::parse($promocode->start_date)->timezone($this->app_settings['timezone'])->format("g:i A")) . '</span>';
                })
                ->addColumn('display_end_date', function ($promocode) {
                    return Carbon::parse($promocode->end_date)->timezone($this->app_settings['timezone'])->format("M d,Y") . '<br>' .
                        '<span class="gray">' . (Carbon::parse($promocode->end_date)->timezone($this->app_settings['timezone'])->format("g:i A")) . '</span>';
                })
                ->addColumn('promo_type', function ($promocode) use ($request) {
                    if (isset($request->promo_type) && !empty($request->promo_type)) {
                        return $request->promo_type;
                    }
                    if ($promocode->start_date <= date("Y-m-d H:i:s") && $promocode->end_date >= date("Y-m-d H:i:s")) {
                        return 1;
                    } else if ($promocode->start_date >= date("Y-m-d H:i:s")) {
                        return 2;
                    } else {
                        return 3;
                    }
                })
                ->addColumn('user_ids', function ($promocode) {
                    $user_ids = UserPromocode::wherePromocodeId($promocode->id)->get()->pluck('user_id')->toArray() ?? [0];
                    $users = User::whereIn('id', $user_ids)->get()->pluck('name')->join(', ') ?? '-';
                    return !empty($users) ? $users : '-';
                })
                ->addColumn('action', function ($promocode) {
                    $action = '<a href="' . url('admin/promo-offers/' . $promocode->id) . '" class="font-large-1"><i class="feather icon-eye"></i></a>';
                    return $action;
                })
                ->rawColumns(['action', 'display_start_date', 'display_end_date'])
                ->make(TRUE);
        }

        $active_promocodes = Promocode::select('*')->orderBy('id', 'desc')->where('start_date', '<=', date("Y-m-d H:i:s"))->where('end_date', '>=', date("Y-m-d H:i:s"))->count();
        $upcoming_promocodes = Promocode::select('*')->orderBy('id', 'desc')->where('start_date', '>=', date("Y-m-d H:i:s"))->count();

        view()->share('page_title', 'Promo/Offers');
        return view('admin.promo-offers.list', compact('active_promocodes', 'upcoming_promocodes'));
    }

    public function save(Request $request)
    {
        $validation = [
            'title' => 'required',
            'promocode' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'used_limit' => 'required',
            // 'user_ids' => 'required',
            'discount_type' => 'required',
            'discount_amount' => 'required',
            // 'status' => 'required',
        ];
        $this->validate($request, $validation);

        $request_data = $request->all();
        // $start_date = $request->start_date . ' ' . $request->start_hour . ':' . $request->start_minute . ' ' . $request->start_am_pm;
        // $end_date = $request->end_date . ' ' . $request->end_hour . ':' . $request->end_minute . ' ' . $request->end_am_pm;
        $start_date = $request->start_date . ' ' . $request->start_time;
        $end_date = $request->end_date . ' ' . $request->end_time;

        $request_data['start_date'] = Carbon::parse($start_date, $this->app_settings['timezone'])->setTimezone('UTC')->format("Y-m-d H:i:s");
        $request_data['end_date'] = Carbon::parse($end_date, $this->app_settings['timezone'])->setTimezone('UTC')->format("Y-m-d H:i:s");

        $request_data['user_ids'] = (isset($request_data['user_ids']) && !empty($request_data['user_ids'])) ? array_filter($request_data['user_ids']) : [];
        $request_data['promocode_type'] = (isset($request_data['user_ids']) && !empty($request_data['user_ids'])) ? 'user' : 'all';

        $request_data['status'] = isset($request_data['status']) ? $request_data['status'] : 0;
        $request_data['one_time_user'] = isset($request_data['one_time_user']) ? $request_data['one_time_user'] : 0;

        if (isset($request_data['promocode_id']) && !empty($request_data['promocode_id'])) {
            $promocode = Promocode::find($request_data['promocode_id'])->update($request_data);
            $promocode_id = $request_data['promocode_id'];
        } else {
            $promocode = Promocode::create($request_data);
            $promocode_id = $promocode->id;
        }
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($promocode) {

            if (isset($request_data['user_ids']) && !empty($request_data['user_ids'])) {
                $request_data['user_ids'] = array_filter($request_data['user_ids']);
                UserPromocode::where('promocode_id', $promocode_id)->whereNotIn('user_id', $request_data['user_ids'])->delete();
                foreach ($request_data['user_ids'] as $user_id) {
                    UserPromocode::firstOrCreate(
                        ['user_id' => $user_id, 'promocode_id' => $promocode_id],
                        ['user_id' => $user_id, 'promocode_id' => $promocode_id]
                    );
                }
            } else {
                UserPromocode::where('promocode_id', $promocode_id)->delete();
            }

            $msg = isset($request_data['promocode_id']) && !empty($request_data['promocode_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'Promocode ' . $msg . ' successfully.'];
        }
        if ($request->ajax()) {
            return response()->json($response);
        } else {
            if ($response['status']) {
                $msg = isset($request_data['promocode_id']) && !empty($request_data['promocode_id']) ? 'updated' : 'created';
                session()->flash('success', 'Promo offer ' . $msg . ' successfully.');
                return redirect(url('admin/promo-offers/' . $promocode_id));
            } else {
                $msg1 = isset($request_data['promocode_id']) && !empty($request_data['promocode_id']) ? 'Updating' : 'Creating';
                session()->flash('error', $msg1 . ' promocode failed, Please try again.');
                return redirect()->back();
            }
        }
    }

    public function delete(Request $request)
    {
        $validation = [
            'promocode_id' => 'required'
        ];
        $request->validate($validation);

        $delete = Promocode::destroy($request->promocode_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Promocode deleted successfully.'];
        }
        return response()->json($response);
    }

    public function show(Request $request, $id = false)
    {
        $promocode = Promocode::find($id) ?? [];
        if (!empty($promocode)) {
            $promocode->start_date = Carbon::parse($promocode->start_date, 'UTC')->setTimezone($this->app_settings['timezone'])->format("Y-m-d");
            $promocode->end_date = Carbon::parse($promocode->end_date, 'UTC')->setTimezone($this->app_settings['timezone'])->format("Y-m-d");
            $promocode->start_time = Carbon::parse($promocode->start_date, 'UTC')->setTimezone($this->app_settings['timezone'])->format("g:i A");
            $promocode->end_time = Carbon::parse($promocode->end_date, 'UTC')->setTimezone($this->app_settings['timezone'])->format("g:i A");
        }
        $promo_users = UserPromocode::wherePromocodeId($id)->get()->pluck('user_id')->toArray() ?? [];
        $users = User::where('user_type', '!=', 'admin')->whereStatus(1)->get();
        view()->share('page_title', (!empty($id) && is_numeric($id) ? 'Update Promotion' : 'Add New Promotion'));
        return view('admin.promo-offers.show', compact('users', 'promocode', 'promo_users'));
    }
}
