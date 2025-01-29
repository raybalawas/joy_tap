<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnimalVideo;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;


class AnimalsVideoController extends Controller
{


    // public function animalVideo(Request $request)
    // {
    //     // dd($request->all());
    //     $videos = AnimalVideo::where('scene_name',$request->scene_name)->where('language', $request->lan)->select('animal_type', 'video_link')->get();
    //     // dd($videos);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Response Received',
    //         'scene_name' => $request->scene_name,
    //         'object' => $videos
    //     ]);

    // }

    // public function animalVideo(Request $request)
    // {
    //     $videoFolder = 'public/AnimalVideos/';

    //     $videos = AnimalVideo::where('scene_name', $request->scene_name)
    //         ->where('language', $request->lan)
    //         ->select('animal_type', 'video_link')
    //         ->get();

    //     $videos = $videos->map(function ($video) use ($videoFolder) {
    //         $video->video_link = asset($videoFolder . $video->video_link);
    //         return $video;
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Response Received',
    //         'scene_name' => $request->scene_name,
    //         'object' => $videos
    //     ]);
    // }


    // public function index(Request $request)
    // {
    //     $videos = AnimalVideo::with('scene')->get();


    //     return response()->json($videos);
    // }




    // public function animalVideo(Request $request)
    // {
    //     // Check if the user is authenticated
    //     // if (!auth()->check()) {
    //     //     return response()->json([
    //     //         'success' => false,
    //     //         'message' => 'Unauthorized access. Please log in.',
    //     //     ], 401);
    //     // }

    //     // // Get the authenticated user
    //     // $user = auth()->user();

    //     // // Check if the user has a preferred language
    //     // $userLanguage = $user->language;

    //     // if (!$userLanguage) {
    //     //     return response()->json([
    //     //         'success' => false,
    //     //         'message' => 'User language not found.',
    //     //     ], 400);
    //     // }

    //     // Default video and audio folders
    //     $videoFolder = 'public/AnimalVideos/';
    //     $lnAudioFolder = 'public/LanguageAudio/';
    //     $sceneAudioFolder = 'public/SceneAudio/';

    //     // Validate required request parameters
    //     $request->validate([
    //         'scene_name' => 'required|string',
    //         'lan' => 'required|string',
    //     ]);

    //     // Fetch videos with their related scene_audio
    //     $videos = AnimalVideo::with('sceneAudio')
    //         ->where('scene_name', $request->scene_name)
    //         ->where('language',  $request->lan)
    //         ->select('animal_type', 'video_link', 'ln_audio', 'scene_audio')
    //         ->get();



    //     // Map video and audio links to include asset paths
    //     $videos = $videos->map(function ($video) use ($videoFolder, $lnAudioFolder, $sceneAudioFolder) {
    //         $video->video_link = asset($videoFolder . $video->video_link); // Video file path
    //         $video->ln_audio = asset($lnAudioFolder . $video->ln_audio);   // Language audio file path

    //         // Replace scene_audio object with direct URL
    //         $video->scene_audio = $video->sceneAudio
    //             ? asset($sceneAudioFolder . $video->sceneAudio->audioFile)
    //             : null;

    //         // Remove the related sceneAudio object from the response
    //         unset($video->sceneAudio);

    //         return $video;
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Response Received',
    //         'scene_name' => $request->scene_name,
    //         'object' => $videos,
    //     ]);
    // }




    public function animalVideo(Request $request)
    {
        $videoFolder = 'public/AnimalVideos/';
        $lnAudioFolder = 'public/LanguageAudio/';
        $sceneAudioFolder = 'public/SceneAudio/';

        $request->validate([
            'scene_name' => 'required|string',
            'lan' => 'required|string',
        ]);

        $animalOrders = [
            'Safari_1' => ['Train', 'Giraffe', 'Parrot', 'Snake', 'Hippo', 'Elephant', 'Monkey'],
            'Safari_2' => ['Bear', 'Bees'],
            'Safari_3' => ['Hippo', 'Elephant', 'Lion', 'Giraffe'],
            'Safari_4' => ['Snake', 'Lion', 'Bear', 'Fish',],
            'Safari_5' => ['Lion', 'Zebra', 'Rahinoes'],
            'Safari_6' => ['Giraffe', 'Monkey', 'Tortule', 'Herones'],
            'Safari_7' => ['Lion', 'Zebra', 'WoodPecker'],
            'Safari_8' => ['Hippo', 'Snake', 'Giraffe', 'Lion', 'Parrot'],
        ];

        $animalOrder = $animalOrders[$request->scene_name] ?? ['Train', 'Giraffe', 'Parrot', 'Snake', 'Hippo', 'Elephant', 'Monkey'];


        if (!$animalOrder) {
            return response()->json(["status" => false, "message" => "Please Select a Screen"], 404);
        }

        $videos = AnimalVideo::with('sceneAudio')
            ->where('scene_name', $request->scene_name)
            ->where('language', $request->lan)
            ->select('id', 'animal_type', 'video_link', 'ln_audio', 'scene_audio')
            ->get();

        $videos = $videos->sortBy(function ($video) use ($animalOrder) {
            return array_search($video->animal_type, $animalOrder);
        });

        // dd($animalOrder);


        // Extract scene audio once (if available)
        $sceneAudio = $videos->first()?->sceneAudio;
        $sceneAudioUrl = $sceneAudio ? asset($sceneAudioFolder . $sceneAudio->audioFile) : null;

        // Map video and audio links to include asset paths
        $videos = $videos->map(function ($video) use ($videoFolder, $lnAudioFolder) {
            $video->video_link = asset($videoFolder . $video->video_link); // Video file path
            $video->ln_audio = asset($lnAudioFolder . $video->ln_audio);   // Language audio file path

            // Remove unnecessary fields
            unset($video->scene_audio, $video->sceneAudio);

            return $video;
        });

        return response()->json([
            'success' => true,
            'message' => 'Response Received',
            'scene_name' => $request->scene_name,
            'scene_audio' => $sceneAudioUrl,
            'object' => $videos->map(function ($video) {
                return [
                    'id' => $video->id,
                    'animal_type' => $video->animal_type,
                    'video_link' => $video->video_link,
                    'ln_audio' => $video->ln_audio,
                ];
            }),
        ]);
    }


    // public function animalVideo(Request $request)
    // {
    //     // Default video and audio folders
    //     $videoFolder = 'public/AnimalVideos/';
    //     $lnAudioFolder = 'public/LanguageAudio/';
    //     $sceneAudioFolder = 'public/SceneAudio/';

    //     // Validate required request parameters
    //     $request->validate([
    //         'scene_name' => 'required|string',
    //         'lan' => 'required|string',
    //     ]);

    //     $animalOrder = ['Train', 'Giraffe', 'Parrot', 'Snake', 'Hippo', 'Elephant', 'Monkey'];

    //     // Fetch videos with their related scene_audio
    //     $videos = AnimalVideo::with('sceneAudio')
    //         ->where('scene_name', $request->scene_name)
    //         ->where('language', $request->lan)
    //         ->select('id', 'animal_type', 'video_link', 'ln_audio', 'scene_audio')
    //         ->get();

    //     // Sort the videos based on the custom order
    //     $videos = $videos->sortBy(function ($video) use ($animalOrder) {
    //         // Get the position of the animal_type in the predefined order
    //         return array_search($video->animal_type, $animalOrder);
    //     });

    //     // Extract scene audio once (if available)
    //     $sceneAudio = $videos->first()?->sceneAudio;
    //     $sceneAudioUrl = $sceneAudio ? asset($sceneAudioFolder . $sceneAudio->audioFile) : null;

    //     // Map video and audio links to include asset paths
    //     $videos = $videos->map(function ($video) use ($videoFolder, $lnAudioFolder) {
    //         $video->video_link = asset($videoFolder . $video->video_link); // Video file path
    //         $video->ln_audio = asset($lnAudioFolder . $video->ln_audio);   // Language audio file path

    //         // Remove unnecessary fields
    //         unset($video->scene_audio, $video->sceneAudio);

    //         return $video;
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Response Received',
    //         'scene_name' => $request->scene_name,
    //         'scene_audio' => $sceneAudioUrl,
    //         // 'object' => $videos,

    //         'object' => $videos->map(function ($video) {
    //             return [
    //                 'id' => $video->id,
    //                 'animal_type' => $video->animal_type,
    //                 'video_link' => $video->video_link,
    //                 'ln_audio' => $video->ln_audio,
    //             ];
    //         })


    //     ]);
    // }


    public function languageEdit()
    {
        try {
            // Check if the user is authenticated
            if (!Auth::check()) {
                // If not authenticated, return a custom error response
                return response()->json(['status' => false, 'message' => 'Unauthorized access. Please login.'], 401);
            }

            // If authenticated, proceed with retrieving the language data
            $lang = Language::select(['id', 'name'])->get();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => $lang,
            ]);
        } catch (\Exception $e) {
            // Log any errors for debugging
            \Log::error('Error in languageEdit: ' . $e->getMessage());

            // Return a generic error message if something goes wrong
            return response()->json(['status' => false, 'message' => 'An unexpected error occurred.'], 500);
        }
    }

    public function languageUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'language' => 'required|exists:languages,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $user = Auth::user();
        // dd($user);

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found']);
        }

        $user->update([
            'language' => $request->language,
        ]);

        return response()->json(['status' => true, 'message' => 'Language updated successfully']);
    }




}
