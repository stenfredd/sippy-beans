<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validation = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required',
            'device_type' => 'required',
            'device_token' => 'required'
        ];
        $request->validate($validation);

        $exist_email = User::whereEmail($request->email)->first();
        if (!empty($exist_email) && isset($exist_email->id)) {
            $message = 'Email already exist!';
            if (!empty($exist_email->social_login)) {
                $message .= 'Please use ' . (!empty($exist_email->google_id) ? 'google' : 'apple') . ' account.';
            }
            return response()->json(['status' => false, 'message' => $message]);
        }

        if (empty($request->input('phone'))) {
            return response()->json(['status' => true, 'message' => 'Verify phone number.']);
        }

        $exist_phone = User::wherePhone($request->phone)->first();
        if (!empty($exist_phone) && isset($exist_phone->id)) {
            return response()->json(['status' => false, 'message' => 'Phone already exist!']);
        }

        $user_data = $request->except('profile_image');
        $user_data['name'] = $request->first_name . ' ' . $request->last_name;
        $user_data['password'] = bcrypt($user_data['password']);

        if ($request->hasFile('profile_image')) {
            $image_file = $request->file('profile_image');
            $image_name = time() . '.' . $image_file->extension();
            $image_file->move(public_path('uploads/users'), $image_name);
            $user_data['profile_image'] = asset('uploads/users/' . $image_name);
        }

        $user_data['status'] = 1;
        $user_data['email_verified_at'] = date("Y-m-d H:i:s");
        $user = User::Create($user_data);
        $response = [
            'status' => false,
            'message' => 'Something went wrong, Please try again.'
        ];
        if ($user) {
            $token_obj = $user->createToken(md5(time()));
            $token = $token_obj->token;

            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
            $token->save();
            $response = [
                'status' => true,
                'message' => 'User register successfully.',
                'expires_at' => Carbon::parse($token_obj->token->expires_at)->toDateTimeString(),
                'token_type' => 'Bearer',
                'access_token' => $token_obj->accessToken,
                'user' => $user
            ];
        }
        return response()->json($response, 201);
    }

    public function socialLoginRegister(Request $request)
    {
        $validation = [
            'email' => 'required|string|email',
            'device_type' => 'required',
            'device_token' => 'required',
            'social_login' => 'required',
            'social_id' => 'required'
        ];
        $request->validate($validation);

        $exist_email = User::whereEmail($request->email)->first();
        if (!empty($exist_email) && isset($exist_email->id)) {
            if ($exist_email->social_login != $request->social_login) {
                $message = 'Email already exist!';
                return response()->json(['status' => false, 'message' => $message]);
            }
            if (empty($exist_email->phone)) {
                return response()->json(['status' => true, 'message' => 'Verify phone number.']);
            }
        }

        if (empty($exist_email) && empty($request->input('phone'))) {
            return response()->json(['status' => true, 'message' => 'Verify phone number.']);
        }
        if (isset($request->phone)) {
            $exist_phone = User::wherePhone($request->phone)->first();
            if (!empty($exist_phone) && isset($exist_phone->id)) {
                if ($exist_phone->social_login != $request->social_login) {
                    return response()->json(['status' => false, 'message' => 'Phone already exist!']);
                }
            }
        }

        $user_data = $request->except('profile_image');
        if (empty($exist_email)) {
            $validation = [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|string|email',
                'phone' => 'required',
                'device_type' => 'required',
                'device_token' => 'required',
                'social_login' => 'required',
                'social_id' => 'required'
            ];
            $request->validate($validation);
            $exist_phone = User::wherePhone($request->phone)->first();
            $user_data['email_verified_at'] = date("Y-m-d H:i:s");
            $user_data['name'] = $request->input('first_name') . ' ' . $request->input('last_name');
        }

        $user_data['password'] = null;

        if ($request->social_login == 1) {
            $user_data['apple_id'] = $request->social_id;
        } else {
            $user_data['google_id'] = $request->social_id;
        }
        unset($user_data['social_id']);

        if ($request->hasFile('profile_image')) {
            $image_file = $request->file('profile_image');
            $image_name = time() . '.' . $image_file->extension();
            $image_file->move(public_path('uploads/users'), $image_name);
            $user_data['profile_image'] = asset('uploads/users/' . $image_name);
        }
        $user_data['status'] = 1;
        $user = User::updateOrCreate(['email' => $request->email], $user_data);

        $response = [
            'status' => false,
            'message' => 'Something went wrong, Please try again.'
        ];
        if ($user) {
            $token_obj = $user->createToken(md5(time()));
            $token = $token_obj->token;

            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
            $token->save();
            $response = [
                'status' => true,
                'message' => 'User register successfully.',
                'expires_at' => Carbon::parse($token_obj->token->expires_at)->toDateTimeString(),
                'token_type' => 'Bearer',
                'access_token' => $token_obj->accessToken,
                'user' => User::find($user->id)
            ];
        }
        return response()->json($response, 201);
    }

    public function login(Request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Invalid Credentials'
        ];
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $exist_email = User::whereEmail($request->email)->where('social_login', '>', 0)->first();
        if (!empty($exist_email) && isset($exist_email->id)) {
            return response()->json(['status' => false, 'message' => 'You signup using ' . ($exist_email->social_login == 1 ? 'apple' : 'google') . ' account. Please use ' . ($exist_email->social_login == 1 ? 'apple' : 'google') . ' account to login.']);
        }

        $credentials = request(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $user = $request->user();

            $token_obj = $user->createToken(md5(time()));
            $token = $token_obj->token;

            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
            $token->save();

            $response = [
                'status' => true,
                'message' => 'Login Successfully!',
                'token_type' => 'Bearer',
                'access_token' => $token_obj->accessToken,
                'expires_at' => Carbon::parse($token_obj->token->expires_at)->toDateTimeString(),
                'user' => $user
            ];
        }
        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        auth()->user()->token()->revoke();
        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully!'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => "We can't find a user with that e-mail address."
            ], 200);
        }

        $credentials = ['email' => $request->email];
        $response = Password::sendResetLink($credentials, function (Message $message) {
            $message->subject($this->getEmailSubject());
        });
        switch ($response) {
            case Password::RESET_LINK_SENT:
                return response()->json(['status' => true, 'message' => 'Reset password link has been send to your mail.']);
            case Password::INVALID_USER:
                return response()->json(['status' => false, 'message' => "We can't find a user with that e-mail address."]);
            default:
                return response()->json(['status' => false, 'message' => "Something went wrong, Please try again"]);
        }
    }
}
