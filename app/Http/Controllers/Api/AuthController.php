<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\ForgetPasswordOtpMail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Services\TwilioService;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;

class AuthController extends Controller
{
    public function api_check()
    {
        return response()->json(['status' => false, 'message' => 'Unauthorized access. Please login.'], 401);

    }
    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         // 'email' => 'required|email|exists:users,email',
    //         // 'password' => 'required|min:8',
    //         'dob' => 'required',
    //         'phone' => 'required'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             "status" => "error",
    //             "message" => $validator->errors()->first()
    //         ], 400);
    //     }
    //     if (Auth::attempt(['dob' => $request->dob, 'phone' => $request->phone])) {
    //         $user = User::where('phone', $request->phone)->first();

    //         // if ($user->is_email_verified == '0') {
    //         $otp = rand(100000, 999999);
    //         $user->otp = $otp;
    //         $user->save();

    //         $data = [
    //             "title" => "verification otp",
    //             "otp" => $otp
    //         ];

    //         Mail::to($request->email)->send(new ForgetPasswordOtpMail($data));
    //         return response()->json([
    //             "status" => "success",
    //             "message" => "Otp send to given email",
    //             "is_email_verified" => $user->is_email_verified,
    //         ], 200);
    //     }
    //     // else

    //     //     $token = $user->createToken('login')->plainTextToken;
    //     // return response()->json([
    //     //     'status' => "success",
    //     //     'message' => 'Login Successfully!',
    //     //     "is_email_verified" => $user->is_email_verified,
    //     //     'token' => $token,
    //     // ], 200);
    //     // }

    //     return response()->json([
    //         "status" => "fail",
    //         "message" => "wrong credentials"
    //     ], 400);
    // }




    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         // 'dob' => 'required',
    //         'phone' => 'required'
    //     ]);
    //     // dd($validator());

    //     if ($validator->fails()) {
    //         return response()->json([
    //             "status" => "error",
    //             "message" => $validator->errors()->first()
    //         ], 400);
    //     }

    //     // Attempt to find the user with dob and phone number
    //     $user = User::where('phone', $request->phone)
    //         ->first();

    //     if ($user) {
    //         // Generate OTP
    //         $otp = rand(100000, 999999);
    //         $user->otp = $otp;
    //         $user->save();

    //         $twilio = new TwilioService();
    //         $response = $twilio->sendOtp($request->phone, $otp);
    //         if (strpos($response, 'Error') !== false) {
    //             return response()->json([
    //                 "status" => "fail",
    //                 "message" => "Failed to send OTP. Error: " . $response
    //             ], 400);
    //         }    
    //         // Assuming the phone is valid for sending OTP
    //         if (isset($user->phone)) {
    //             $data = [
    //                 "title" => "Verification OTP",
    //                 "otp" => $otp
    //             ];

    //             // You can use SMS service like Twilio or Nexmo for phone-based OTP
    //             // Mail::to($user->phone)->send(new ForgetPasswordOtpMail($data));  // Or send SMS instead

    //             return response()->json([
    //                 "status" => "success",

    //                 "message" => "OTP sent to your mobile number.",
    //                 "data" => $data
    //                 // "is_email_verified" => $user->is_email_verified ?? false,
    //             ], 200);
    //         } else {
    //             return response()->json([
    //                 "status" => "fail",
    //                 "message" => "No phone number found for this user"
    //             ], 400);
    //         }
    //     }

    //     return response()->json([
    //         "status" => "fail",
    //         "message" => "Wrong credentials"
    //     ], 400);

    // }





    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ], 400);
        }

        $phoneNumber = $request->phone;

        // Format the phone number for India (+91 country code)
        try {
            $phoneUtil = PhoneNumberUtil::getInstance();

            // "IN" is the country code for India
            $parsedPhone = $phoneUtil->parse($phoneNumber, "IN");
            $formattedPhone = $phoneUtil->format($parsedPhone, PhoneNumberFormat::E164);
        } catch (\libphonenumber\NumberParseException $e) {
            return response()->json([
                "status" => "fail",
                "message" => "Invalid phone number format."
            ], 400);
        }

        // Check if user exists
        $user = User::where('phone', $formattedPhone)->first();

        if (!$user) {
            // If user does not exist, create a new user and send OTP
            $user = new User();
            $user->phone = $formattedPhone;
            $user->otp = rand(100000, 999999); // Generate OTP
            $user->save();
        } else {
            // If user exists, generate OTP and save it
            $user->otp = rand(100000, 999999); // Generate new OTP
            $user->save();
        }

        // Send OTP using Twilio
        $twilio = new TwilioService();
        $response = $twilio->sendOtp($formattedPhone, $user->otp);

        if (strpos($response, 'Error') !== false) {
            return response()->json([
                "status" => "fail",
                "message" => "Failed to send OTP. Error: " . $response
            ], 400);
        }

        return response()->json([
            "status" => "success",
            "message" => "OTP sent to your mobile number.",
            "data" => ["otp" => $user->otp] // For testing, remove in production
        ], 200);
    }



    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'full_name' => 'required|min:3',

            'full_name' => [
                'required',
                'min:3',
                'regex:/^(?!^\d+$)[A-Za-z0-9\s]+$/'
            ],

            'phone' => 'required|regex:/^\+?[0-9]{10,15}$/|unique:users',
            'dob' => 'required|date|before:today',
            'class' => 'required|in:1,2,3,4,5,6,7,8,9,10',
            'language' => 'required|exists:languages,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ], 400);
        }


        $user = User::create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'class' => $request->class,
            'language' => $request->language,
        ]);

        // dd($user);
        // $userInfo = User::where('phone', $request->phone)->first();

        // $otp = rand(100000, 999999);

        // if ($userInfo) {
        //     if ($userInfo->is_email_verified == 1) {
        //         return response()->json([
        //             "status" => "error",
        //             "message" => "User already exists",
        //         ], 200);
        //     }

        //     $this->saveUserData($userInfo, $request, $otp);
        // } else {
        //     $userInfo = new User;
        //     $this->saveUserData($userInfo, $request, $otp);
        // }

        // $data = [
        //     "title" => "Verification OTP",
        //     "otp" => $otp
        // ];

        // Mail::to($request->email)->send(new ForgetPasswordOtpMail($data));

        return response()->json([
            "status" => "success",
            "message" => "Registration Successfully!",
        ], 200);

    }

    private function saveUserData(User $user, Request $request, int $otp): void
    {
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $profile_image = rand(100, 10000) . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'admin-assets/uploads/profileimages/';
            $file->move(public_path($destinationPath), $profile_image);
            $user->profile_image = $profile_image;
        }

        $user->otp = $otp;
        $user->full_name = $request->full_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
    }
    public function registerOld(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required',
            'full_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ], 400);
        }
        $userInfo = User::where('email', $request->email)->first();
        if (isset($userInfo)) {
            if ($userInfo->is_email_verified == 1) {
                return response()->json([
                    "status" => "error",
                    "message" => "user already exists",
                ], 200);
            } else {
                $otp = rand(100000, 999999);
                $userInfo->otp = $otp;

                if ($request->hasFile('profile_image')) {
                    $file = $request->file('profile_image');
                    $profile_image = rand(100, 10000) . '.' . $file->getClientOriginalExtension();
                    $destinationPath = 'admin-assets/uploads/profileimages/';
                    $file->move(public_path($destinationPath), $profile_image);
                    $userInfo->profile_image = $profile_image;
                }

                $userInfo->full_name = $request->full_name;
                $userInfo->phone = $request->phone;
                $userInfo->email = $request->email;
                $userInfo->password = Hash::make($request->password);
                $userInfo->save();

                $data = [
                    "title" => "Email verification otp",
                    "otp" => $otp
                ];

                Mail::to($request->email)->send(new ForgetPasswordOtpMail($data));
                return response()->json([
                    "status" => "success",
                    "message" => "Otp send to given email",
                ], 200);
            }
        } else {

            $otp = rand(100000, 999999);
            $user = new User;

            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $profile_image = rand(100, 10000) . '.' . $file->getClientOriginalExtension();
                $destinationPath = 'admin-assets/uploads/profileimages/';
                $file->move(public_path($destinationPath), $profile_image);
                $user->profile_image = $profile_image;
            }

            $user->otp = $otp;
            $user->full_name = $request->full_name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make(value: $request->password);
            $user->save();

            $data = [
                "title" => "Email verification otp",
                "otp" => $otp
            ];

            Mail::to($request->email)->send(new ForgetPasswordOtpMail($data));
            return response()->json([
                "status" => "success",
                "message" => "Otp send to given email",
            ], 200);
        }
    }
    public function logout()
    {
        $user = auth('sanctum')->user();
        if ($user) {
            $user->tokens()->delete();
            return response()->json([
                "status" => "success",
                "message" => "user logout successfully"
            ], 200);
        }

        return response()->json([
            "status" => "failed",
            "message" => "please login first"
        ], 400);
    }
    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ], 400);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->save();

            $data = [
                "title" => "Forget Password Otp",
                "otp" => $otp
            ];

            Mail::to($request->email)->send(new ForgetPasswordOtpMail($data));
            return response()->json([
                "status" => "success",
                "message" => "Otp send successfully on your mail"
            ], 200);
        }
        return response()->json([
            "status" => "error",
            "message" => "user not found"
        ], 400);
    }
    // public function verifyOtp(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email|exists:users,email',
    //         'otp' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             "status" => "error",
    //             "message" => $validator->errors()->first()
    //         ], 400);
    //     }
    //     $user = User::where(['email' => $request->email])->first();
    //     if (!$user) {
    //         return response()->json(["status" => "error", "message" => "user not found"]);
    //     }

    //     if ($user->otp == $request->otp) {
    //         $user->otp = null;
    //         $user->is_email_verified = '1';
    //         $user->save();
    //         $token = $user->createToken('login')->plainTextToken;
    //         return response()->json(["status" => "success", "message" => "otp match successfully", 'token' => $token], 200);
    //     }
    //     return response()->json(["status" => "error", "message" => "otp does not match"], 400);
    // }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ], 400);
        }

        // Get user based on phone number
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(["status" => "error", "message" => "User not found"]);
        }

        // Optionally, you could check if OTP is expired, for example:
        // if (now()->diffInMinutes($user->otp_created_at) > 5) {  // Assuming `otp_created_at` is the time OTP was generated
        //     return response()->json(["status" => "error", "message" => "OTP expired"]);
        // }

        // Validate OTP
        if ($user->otp == $request->otp) {
            $user->otp = null; // Clear OTP after successful verification
            $user->save();

            // Generate token
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'token' => $token,
            ], 200);

        }

        return response()->json([
            "status" => "error",
            "message" => "Wrong Crediential! OTP or DOB does not match."
        ], 400);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ], 400);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                "status" => "success",
                "message" => "password reset successfully"
            ], 200);
        }
        return response()->json([
            "status" => "error",
            "message" => "user not found"
        ], 400);
    }

}
