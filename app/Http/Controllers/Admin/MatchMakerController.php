<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MatchMakers;

class MatchMakerController extends Controller
{
    public function index(Request $request)
    {
        $match_makers = MatchMakers::select('*')->orderBy('id', 'desc')->get();
        view()->share('page_title', 'Match-Makers');
        return view('admin.match-makers.list', compact('match_makers'));
    }

    public function save(Request $request)
    {
        $validation = [
            'match_maker' => 'required'
        ];
        $this->validate($request, $validation);

        $match_makers = $request->match_maker;
        foreach($match_makers as $match_maker) {
            MatchMakers::where("id", $match_maker['id'])->update($match_maker);
        }

        session()->flash('success', 'Match makers details updated successfully.');
        return redirect(url('admin/match-makers'));

        /*$validation = [
            'question' => 'required',
            'type' => 'required',
            'min_select' => 'required|min:0|max:20|numeric',
            'max_select' => 'required|min:0|max:20|numeric'
        ];
        $this->validate($request, $validation);

        $request_data = $request->all();
        if (isset($request_data['match_maker_id']) && !empty($request_data['match_maker_id'])) {
            $user = MatchMakers::find($request_data['match_maker_id'])->update($request_data);
        } else {
            $user = MatchMakers::create($request_data);
        }
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($user) {
            $msg = isset($request_data['match_maker_id']) && !empty($request_data['match_maker_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'MatchMakers ' . $msg . ' successfully.'];
        }
        return response()->json($response);*/
    }
    public function delete(Request $request)
    {
        $validation = [
            'match_maker_id' => 'required'
        ];
        $request->validate($validation);

        $delete = MatchMakers::destroy($request->match_maker_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Match maker deleted successfully.'];
        }
        return response()->json($response);
    }
    public function updateSortOrders(Request $request)
    {
        $request->validate([
            'sorting_match_makers' => 'required'
        ]);

        $sorting_match_makers = json_decode($request->sorting_match_makers, true);
        foreach ($sorting_match_makers as $match_maker) {
            MatchMakers::find($match_maker['match_maker_id'])->update(['display_order' => $match_maker['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Match makers sorting order applied successfully.'];
        return response()->json($response);
    }
}
