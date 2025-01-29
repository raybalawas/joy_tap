<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\AnimalVideo;
use App\Models\Language;
use App\Models\SceneAudio;
use App\Models\User;
use App\Models\PlanModel;
use App\Models\Admin;
use App\Models\Vertical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $total_users = User::count();
        $total_videos = AnimalVideo::count();
        $total_scene_audio = SceneAudio::count();
        $total_language = Language::count();
        return view('admin.dashboard', compact('total_users', 'total_videos', 'total_scene_audio', 'total_language'));
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login')->with('success', 'User Logout Successfully');
    }
    public function profile(Request $request)
    {
        $data = Auth::guard('admin')->user();
        // dd($data);
        return view('admin.users.admin.profile', compact('data'));
    }
}

