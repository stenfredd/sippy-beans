<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    public function index(Request $request)
    {
        $attributes_title = [
            'Origin',
            'Roaster Type',
            'Roaster Level',
            'Process',
            'Characteristics',
            'Product Type',
            'Best For',
            'Brand',
            'Seller',
            'Weight'
        ];
        $attributes = [
            'origins',
            'types',
            'levels',
            'processes',
            'characteristics',
            'coffee_types',
            'best_fors',
            'brands',
            'sellers',
            'weights'
        ];
        $db_attributes = [];
        foreach ($attributes as $index => $attribute) {
            $db_attributes[] = [
                'key' => $attribute,
                'title' => $attributes_title[$index], // ucfirst(str_replace('_', ' ', $attribute)),
                'counts' => DB::table($attribute)->whereStatus(1)->count()
            ];
        }
        view()->share('page_title', 'Attributes');
        return view('admin.attributes.list', compact('db_attributes'));
    }

    public function save(Request $request)
    {
        $validation = [
            'attribute_type' => 'required',
            'attributes_list' => 'required'
        ];
        $request->validate($validation);

        $key = 'title';
        if ($request->attribute_type == 'brands') {
            $key = 'name';
        }
        if ($request->attribute_type == 'coffee_flavor') {
            $key = 'flavor_name';
        }
        if ($request->attribute_type == 'levels') {
            $key = 'level_title';
        }
        if ($request->attribute_type == 'origins') {
            $key = 'origin_name';
        }
        if ($request->attribute_type == 'sellers') {
            $key = 'seller_name';
        }

        $request->attributes_list = array_filter($request->attributes_list);
        if ($request->attribute_type == 'sellers') {
            $request->attributes_emails = array_filter($request->attributes_emails);
        }

        $i = 1;
        foreach ($request->attributes_list as $k => $item) {
            $dbData = [
                $key => $item,
                'display_order' => $i,
                'status' => 1,
                'updated_at' => date("Y-m-d H:i:s")
            ];
            if ($request->attribute_type == 'sellers') {
                $dbData['seller_email'] = $request->attributes_emails[$k];
            }
            $i++;

            $attr = DB::table($request->attribute_type)->where('id', $k)->first();
            if(!empty($attr) && isset($attr->id)) {
                DB::table($request->attribute_type)->where('id', $k)->update($dbData);
            }
            else {
                $dbData['created_at'] = date("Y-m-d H:i:s");
                DB::table($request->attribute_type)->insert($dbData);
            }
            /*if($key == 'seller_name') {
                $item = $request->attributes_list_old[$k];
            }
            if (DB::table($request->attribute_type)->where($key, $item)->count() === 0) {
                if ($key == 'seller_name') {
                    $item = $request->attributes_list[$k];
                }
                $data_insert = [
                    $key => $item,
                    'display_order' => ($k + 1),
                    'status' => 1,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];
                if ($request->attribute_type == 'sellers') {
                    $data_insert['seller_email'] = $request->attributes_emails[$k];
                }
                DB::table($request->attribute_type)->insert($data_insert);
            } else {
                $update_data = [
                    'display_order' => ($k + 1),
                    'status' => 1,
                    'updated_at' => date("Y-m-d H:i:s")
                ];
                if ($request->attribute_type == 'sellers') {
                    $update_data['seller_name'] = $request->attributes_list[$k];
                    $update_data['seller_email'] = $request->attributes_emails[$k];
                }
                DB::table($request->attribute_type)->where($key, $item)->update($update_data);
            }*/
        }

        session()->flash('success', 'Attribute details updated successfully.');
        return redirect(url('admin/attributes/' . $request->attribute_type));
    }

    public function delete(Request $request)
    {
        $validation = [
            'id' => 'required',
            'type' => 'required'
        ];
        $request->validate($validation);

        $delete = DB::table($request->type)->where('id', $request->id)->delete();
        $response = ['status' => false, 'message' => 'Something went wrong, Please try again.'];
        if ($delete) {
            $response = ['status' => true, 'message' => (ucfirst(str_replace('_', ' ', $request->type))) . ' deleted successfully.'];
        }
        return response()->json($response);
    }

    public function show(Request $request, $key = null)
    {
        $attributes = DB::table($key)->orderBy('display_order')->get();
        view()->share('page_title', 'Update Attributes');
        return view('admin.attributes.show', compact('attributes'));
    }

    public function updateSortOrders(Request $request)
    {
        $request->validate([
            'sorting_attributes' => 'required',
            'type' => 'required'
        ]);

        $sorting_attributes = json_decode($request->sorting_attributes, true);
        foreach ($sorting_attributes as $attribute) {
            DB::table($request->type)->where('id', $attribute['attribute_id'])->update(['display_order' => $attribute['sort_order']]);
        }
        $response = ['status' => true, 'message' => 'Attribute sorting order applied successfully.'];
        return response()->json($response);
    }

    public function addAttribute(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required'
        ]);

        $key = 'title';
        if ($request->type == 'brand') {
            $key = 'name';
        }
        if ($request->type == 'coffee_flavor') {
            $key = 'flavor_name';
        }
        if ($request->type == 'level') {
            $key = 'level_title';
        }

        DB::table($request->type)->create([$key => $request->title]);
        $response = ['status' => true, 'message' => 'Attribute created successfully.'];
        return response()->json($response);
    }
}
