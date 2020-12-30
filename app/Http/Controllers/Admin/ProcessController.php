<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Process;
use Yajra\DataTables\Facades\DataTables;

class ProcessController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $processes = Process::select('*')->orderBy('id', 'asc')->get();

            return DataTables::of($processes)
                ->addIndexColumn()                
                ->addColumn('action', function ($process) {
                    $action = '<div class="d-inline-flex">';
                    $action .= '<a class="btn btn-sm btn-icon btn-warning mr-1 mb-1 waves-effect waves-light" href="javascript:" onclick="showAddEditModal(this, true)"><i class="feather icon-edit"></i></a>';
                    $action .= '<a class="btn btn-sm btn-icon btn-danger mb-1 waves-effect waves-light" onclick="deleteProcess(this)" data-id="' . $process->id . '" href="javascript:"><i class="feather icon-trash-2"></i></a>';
                    $action .= "</div>";
                    return $action;
                })
                ->make(TRUE);
        }
        return view('admin.process');
    }
    public function save(Request $request)
    {
        $validation = [           
            'title' => 'required',
        ];
        $this->validate($request, $validation);
        $request_data = $request->all();
        if (isset($request_data['process_id']) && !empty($request_data['process_id'])) {
            $user = Process::find($request_data['process_id'])->update($request_data);
        } else {
            $user = Process::create($request_data);
        }
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($user) {
            $msg = isset($request_data['process_id']) && !empty($request_data['process_id']) ? 'updated' : 'created';
            $response = ['status' => true, 'message' => 'Process ' . $msg . ' successfully.'];
        }
        return response()->json($response);
    }
    public function delete(Request $request) {
        $validation = [
            'process_id' => 'required'
        ];
        $request->validate($validation);

        $delete = Process::destroy($request->process_id);
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => 'Process deleted successfully.'];
        }
        return response()->json($response);
    }

    public function updateSortOrders(Request $request) {
        $request->validate([
            'sorting_process' => 'required'
        ]);

        $sorting_process = json_decode($request->sorting_origin, true);
        foreach($sorting_process as $process) {
            Process::find($process['origin_id'])->update(['display_order' => $process['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Process sorting order applied successfully.'];
        return response()->json($response);
    }

}
