<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserAddress;
use App\User;
use App\UserReward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $user_id = auth('api')->user()->id;
        $user = User::find($user_id);
        $response = [
            'status' => true,
            'user' => $user
        ];
        return response()->json($response);
    }

    public function updateProfile(Request $request)
    {
        $request_data = $request->except('profile_image');
        $request_data = array_filter($request_data);

        $update = false;
        $user = User::find(auth()->id());
        if (!empty($user) && isset($user->id)) {
            if(isset($request->email) && !empty($request->email)) {
                $exist_email = User::whereEmail($request->email)->where('id', '!=', $user->id)->first();
                if (!empty($exist_email) && isset($exist_email->id)) {
                    return response()->json(['status' => false, 'message' => 'Email already exist.']);
                }
            }

            if(isset($request->phone) && !empty($request->phone)) {
                $exist_phone = User::wherePhone($request->phone)->where('id', '!=', $user->id)->first();
                if (!empty($exist_phone) && isset($exist_phone->id)) {
                    return response()->json(['status' => false, 'message' => 'Phone already exist.']);
                }
            }

            if(isset($request->password) && !empty($request->password)) {
                $request_data['password'] = Hash::make($request_data['password']);
            }
            $request_data['name'] = ($request_data['first_name'] ?? $user->first_name) . ' ' . ($request_data['last_name'] ?? $user->last_name);
            if ($request->hasFile('profile_image')) {
                $image_file = $request->file('profile_image');
                $image_name = time() . '.' . $image_file->extension();
                $image_file->move(public_path('uploads/users'), $image_name);
                $request_data['profile_image'] = asset('uploads/users/' . $image_name);
            }
            $update = $user->update($request_data);
        }

        $user = User::find($user->id);

        $response = [
            'status' => $update,
            'message' => $update ? 'Profile updated successfully!' : 'Updating profile failed, Please try again',
            'user' => $user
        ];
        return response()->json($response);
    }

    public function getAddress(Request $request)
    {
        $response = [
            'status' => false,
            'message' => 'No found address details',
            'addresses' => []
        ];

        $user_id = auth('api')->user()->id;
        $addresses = UserAddress::latest()->whereUserId($user_id)->with(['city', 'country'])->get();
        if (!empty($addresses) && count($addresses) > 0) {
            foreach($addresses as $address) {
                $address->city_name = $address->city->name ?? null;
                $address->country_name = $address->country->country_name ?? null;
                unset($address->city);
                unset($address->country);
            }
            $response = [
                'status' => true,
                'message' => count($addresses) . ' addresses found.',
                'addresses' => $addresses
            ];
        }

        return response()->json($response);
    }

    public function saveAddress(Request $request)
    {
        $validation = [
            'title' => 'required',
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city_id' => 'required',
            'country_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ];
        if(isset($request->address_id) && !empty($request->address_id)) {
            if(isset($request->is_default) && !empty($request->is_default)) {
                $validation = [
                    'address_id' => 'required',
                    'is_default' => 'required'
                ];
            }
        }
        $request->validate($validation);

        $response = [
            'status' => false,
            'message' => 'Something went wrong, Please try again.',
            'addresses' => []
        ];

        if(isset($request->is_default) && $request->is_default == 1) {
            UserAddress::whereUserId(auth('api')->user()->id)->update(['is_default' => 0]);
        }

        $request_data = $request->except('address_id');
        $request_data['user_id'] = auth('api')->user()->id;
        if(isset($request->address_id) && !empty($request->address_id)) {
            $address = UserAddress::find($request->address_id);
            if(empty($address) || !isset($address->id)) {
                return response()->json($response);
            }
            $address->update($request_data);
        }
        else {
            $address = UserAddress::create($request_data);
        }
        if (!empty($address) && isset($address->id)) {
            $response = ['status' => true, 'message' => 'Address details saved successfully.', 'address_id' => $address->id];
        }

        return response()->json($response);
    }

    public function deleteAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required'
        ]);

        $response = [
            'status' => false,
            'message' => 'Deleting address failed, Please try again.'
        ];

        if(Order::whereAddressId($request->address_id)->count() > 0) {
            return response()->json(['status' => false, 'message' => 'Address cuurently in use, so not able to delete.']);
        }
        $delete = UserAddress::destroy($request->address_id);
        if ($delete) {
            $user_id = auth('api')->user()->id;
            $addresses = UserAddress::latest()->whereUserId($user_id)->with(['city', 'country'])->get();
            if (!empty($addresses) && count($addresses) > 0) {
                foreach($addresses as $address) {
                    $address->city_name = $address->city->name ?? null;
                    $address->country_name = $address->country->name ?? null;
                    unset($address->city);
                    unset($address->country);
                }
            }
            $response = [
                'status' => true,
                'message' => 'Address details deleted successfully.',
                'addresses' => $addresses
            ];
        }

        return response()->json($response);
    }
}
