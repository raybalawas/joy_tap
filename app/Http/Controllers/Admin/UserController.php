<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\CreatorBrandProfile;
use Illuminate\Support\Facades\Auth;
use App\Models\Vertical;
use App\Models\UsersInstagramUpdateRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Validator;

class UserController extends Controller
{
    public function userList(Request $request)
    {
        // dd('ok');
        $allUsers = User::with('languages')->orderBy('id', 'desc')->get();
        // dd($allUsers->languages->name);
        $languages = Language::all();
        // dd($allUsers);
        return view('admin.users.index', compact('allUsers', 'languages'));
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'full_name' => [
                'required',
                'min:3',
                'regex:/^(?!^\d+$)[A-Za-z0-9\s]+$/'
            ],
            'phone' => 'required|regex:/^\+?[0-9]{10,15}$/|unique:users',
            'dob' => 'required|date|before:today',
            'class' => 'required|in:1,2,3,4,5,6,7,8,9,10',
            'language' => 'required|exists:languages,id',
        ], [
            'phone.unique' => 'This phone number is already registered.',
        ]);
        // ----image upload----
        // if ($request->hasFile('profile_image')) {

        //     $file = $request->file('profile_image');
        //     $image = rand(100, 100000) . '.' . $file->getClientOriginalExtension();
        //     $destinationPath = 'admin-assets/uploads/profileimages/';
        //     $file->move(public_path($destinationPath), $image);
        //     $data['profile_image'] = $image;
        // }

        // ----
        // $data['full_name'] = $request->full_name;
        // $data['email'] = $request->email;
        // $data['status'] = $request->status;
        // $data['phone'] = $request->phone;
        // $data['password'] = Hash::make($request->password);
        // -----


        // Try to create the user
        try {
            User::create([
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'class' => $request->class,
                'language' => $request->language,
            ]);

            return response()->json(['success' => true, 'message' => 'User created successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }

    }
    // public function userUpdate(Request $request)
    // {
    //     $request->validate([
    //         'full_name' => 'required',
    //         'phone' => 'required|min:10',
    //         'email' => 'required|unique:users,email,' . $request->user_id,
    //     ]);
    //     // --image---
    //     $user = User::where('id', $request->user_id)->first();
    //     // ----image upload----
    //     if ($request->hasFile('profile_image')) {

    //         //deleting previous image
    //         $image_path = public_path('admin-assets/uploads/profileimages/') . basename($user->profile_image);

    //         if (File::exists($image_path)) {
    //             File::delete($image_path);
    //         }

    //         $file = $request->file('profile_image');
    //         $image = rand(100, 100000) . '.' . $file->getClientOriginalExtension();
    //         $destinationPath = 'admin-assets/uploads/profileimages/';
    //         $file->move(public_path($destinationPath), $image);
    //         $data['profile_image'] = $image;
    //     }

    //     $data['full_name'] = $request->full_name;
    //     $data['email'] = $request->email;
    //     $data['status'] = $request->status;
    //     $data['phone'] = $request->phone;

    //     User::where('id', $request->user_id)->update($data);
    //     return redirect()->route('user.list')->with('success', 'User Detail Update Successfully');
    // }

    public function userUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => [
                'required',
                'min:3',
                'regex:/^(?!^\d+$)[A-Za-z0-9\s]+$/'
            ],

            // 'phone' => 'required|regex:/^\+?[0-9]{10,15}$/|unique:users',
            'dob' => 'required|date|before:today',
            'class' => 'required|in:1,2,3,4,5,6,7,8,9,10',
            'language' => 'required|exists:languages,id',
        ], [
            'full_name.regex' => 'Name may contain numbers and alphabets mixed, but cannot be only numbers.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found']);
        }

        $user->update([
            'full_name' => $request->full_name,
            // 'phone' => $request->phone,
            'dob' => $request->dob,
            'class' => $request->class,
            'language' => $request->language,

        ]);

        return response()->json(['status' => true, 'message' => 'User details updated successfully']);
    }

    public function userDelete($id)
    {
        $user = User::find($id);
        // $image_path = public_path('admin-assets/uploads/profileimages/') . $data->profile_image;
        // if (File::exists($image_path)) {
        //     File::delete($image_path);
        // }

        if ($user) {
            // Delete the user
            $user->delete();
            return response()->json(['success' => true, 'message' => 'User deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }

        // return redirect()->route('user.list')->with('success', 'User Deleted Successfully');
    }
    public function updateAdminProfile(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp'
        ]);

        $admin_id = Auth::guard('admin')->user()->id;
        $user = Admin::where('id', $admin_id)->first();

        if ($request->hasFile('image')) {
            //deleting previous image
            $ImagePath = public_path('admin-assets/uploads/profileimages/') . $user->profile_image;
            File::delete($ImagePath);
            $user->delete();

            $file = $request->file('image');
            $admin_profile_image = rand(100, 10000) . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'admin-assets/uploads/profileimages/';
            $file->move(public_path($destinationPath), $admin_profile_image);
            $user->profile_image = $admin_profile_image;
        }
        $user->save();
        return back()->with('success', 'Profile image updated successfully');
    }
    public function emailExistsOrNote(Request $request)
    {
        $email = $request->input('email');
        $exists = User::where('email', $email)->exists();
        if (!$exists) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error']);
    }
    public function userStatusChange(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        if ($user) {
            $current_status = $user->status;
            $user->status = $current_status == "active" ? "inactive" : "active";
            $user->save();
            return response()->json(["status" => "success", "message" => "status changed successfully", "user_status" => $user->status]);
        }
        return response()->json(["status" => "error", "message" => "user not found"]);
    }
}
