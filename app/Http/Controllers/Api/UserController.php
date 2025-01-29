<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Mail\ForgetPasswordOtpMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function viewProfile()
    {
        $user = auth('sanctum')->user();
        if (!isset($user)) {
            return response()->json(['status' => 'error', 'message' => 'user not found']);
        } else {
            $user_info = User::select('full_name', 'phone', 'language', 'dob', 'class')->first();
            return response()->json(['status' => 'success', 'data' => $user_info]);
        }
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'full_name' => 'required|min:3|regex:^(?!^\d+$)[A-Za-z0-9\s]+$',
            'full_name' => [
                'required',
                'min:3',
                'regex:/^(?!^\d+$)[A-Za-z0-9\s]+$/'
            ],

            // 'phone' => 'required|regex:/^\+?[0-9]{10,15}$/|unique:users',
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

        $user = auth('sanctum')->user();

        if (!isset($user)) {
            return response()->json(['status' => 'error', 'message' => 'user not found']);
        } else {
            $user = User::where('id', $user->id)->first();
            $user->full_name = $request->full_name;
            // $user->phone = $request->phone;
            $user->dob = $request->dob;
            $user->class = $request->class;
            $user->language = $request->language;

            // if ($request->hasFile('profile_image')) {

            //     if (!empty($user->profile_image)) {
            //         $oldImagePath = public_path('admin-assets/uploads/profileimages/' . $user->profile_image);
            //         if (file_exists($oldImagePath)) {
            //             unlink($oldImagePath);
            //         }
            //     }

            // $file = $request->file('profile_image');
            // $profile_image = rand(100, 10000) . '.' . $file->getClientOriginalExtension();
            // $destinationPath = 'admin-assets/uploads/profileimages/';
            // $file->move(public_path($destinationPath), $profile_image);
            // $user->profile_image = $profile_image;
        }

        $user->save();

        // $data = User::with('languages:id, name')->where('id', $user->id)->select('id', 'full_name', 'phone', 'dob', 'class')->get();
        $user = User::with(['languages:id,name'])
            ->select('id', 'full_name', 'phone', 'dob', 'class', 'language')
            ->where('id', $user->id)
            ->first();

        $data = [
            'id' => $user->id,
            'full_name' => $user->full_name,
            'phone' => $user->phone,
            'dob' => $user->dob,
            'class' => $user->class,
            'language' => $user->languages->name,
        ];

        return response()->json(['status' => 'success', 'data' => $data, 'message' => 'user profile updated successfully']);

    }
}


// public function userList(Request $request)
// {
//     $allUsers = User::all();


//     return response()->json([
//         'status' => true,
//         'message' => 'User list retrieved successfully.',
//         'data' => $allUsers
//     ]);
//     // return view('admin.users.index', compact('allUsers'));
// }


// public function userStore(Request $request)
// {
//     $request->validate([
//         'full_name' => 'required',
//         'email' => 'required|email|unique:users,email',
//         'dob' => 'required',
//         'class' => 'required',
//     ]);

//     $user = User::create($request->all());

//     return response()->json([
//         'status' => true,
//         'message' => 'User created successfully.',
//         'data' => $user,
//     ]);
// }



// public function userUpdate(Request $request)
// {
//     // dd($request->all());
//     $validator = Validator::make($request->all(), [
//         'full_name' => 'required',
//         'email' => 'required|email|unique:users,email,' . $request->user_id,
//         'dob' => 'required|date',
//         'class' => 'required|integer',
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['status' => false, 'errors' => $validator->errors()]);
//     }

//     $user = User::find($request->user_id);
//     if (!$user) {
//         return response()->json(['status' => false, 'message' => 'User not found']);
//     }

//     $user->update([
//         'full_name' => $request->full_name,
//         'email' => $request->email,
//         'dob' => $request->dob,
//         'class' => $request->class,
//     ]);

//     return response()->json([
//         'status' => true,
//         'message' => 'User details updated successfully',
//         'data' => $user

//     ]);
// }


// public function userDelete($id)
// {
//     $data = User::find($id);

//     $data->delete();

//     return response()->json([
//         'status' => true,
//         'message' => 'User Deleted Successfully',
//         'data' => $data,
//     ]);


//     // return redirect()->route('user.list')->with('success', 'User Deleted Successfully');
// }
// }
