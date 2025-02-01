<?php

namespace App\Http\Controllers;

use App\Models\AnimalVideo;
use App\Models\Language;
use App\Models\Scene;
use App\Models\SceneAudio;
use Illuminate\Http\Request;

class AnimalVideoController extends Controller
{
    public function index(Request $request)
    {
        $currentPage = $request->get('page', 1);
        $totalPages = ceil(AnimalVideo::count() / 10);
        // dd(ceil($totalPages));
        if ($currentPage > $totalPages) {
            return redirect()->back();
        }

        // $currentPage = $request->get("page", 1);

        // $totalPages = AnimalVideo::count() / 10;

        // if ($currentPage > $totalPages) {
        //     return redirect()->back();
        // }

        $videos = AnimalVideo::with('sceneAudio')->with('languages')->paginate(10); // Eager load SceneAudio

        $SceneAudios = SceneAudio::all();
        $languages = Language::all();
        $safaries = [
            'safari_1' => ['Snake', 'Elephant', 'Hippo', 'Monkey', 'Giraffe', 'Parrot'],
            'safari_2' => ['Bear', 'Bees'],
            'safari_3' => ['Hippo', 'Elephant', 'Lion', 'Giraffe'],
            'safari_4' => ['Snake', 'Lion', 'Bear', 'Fish'],
            'safari_5' => ['Lion', 'Zebra', 'Rahinoes'],
            'safari_6' => ['Giraffe', 'Monkey', 'Tortule', 'Herones'],
            'safari_7' => ['Lion', 'Zebra', 'WoodPecker'],
            'safari_8' => ['Hippo', 'Snake', 'Giraffe', 'Lion', 'Parrot']
        ];
        // Define the available languages for each animal in each scene (Now with 19 languages)
        // $languages = [
        //     'Snake' => ['Ar', 'Cs', 'EnAu', 'En-Gb', 'Es', 'Fr', 'He', 'Hi', 'Ja', 'Lng-1', 'Lng-2', 'Lng-3', 'Lng-4', 'Lng-5', 'Lng-6', 'Lng-7', 'Lng-8', 'Lng-9'],
        //     'Elephant' => ['Enu', 'He', 'Hi', 'Ja', 'Es', 'Fr', 'Ar', 'Lng-1', 'Lng-2', 'Lng-3', 'Lng-4', 'Lng-5', 'Lng-6', 'Lng-7', 'Lng-8', 'Lng-9', 'Lng-10', 'Lng-11'],
        //     'Hippo' => ['Enu', 'Hi', 'Ja', 'Fr', 'Lng-11', 'Ar', 'Lng-1', 'Lng-2', 'Lng-3', 'Lng-4', 'Lng-5', 'Lng-6', 'Lng-7', 'Lng-8', 'Lng-9', 'Lng-10', 'Lng-12', 'Lng-13'],
        //     'Monkey' => ['EnAu', 'Cs', 'En-Gb', 'Hi', 'Fr', 'Lng-1', 'Lng-2', 'Lng-3', 'Lng-4', 'Lng-5', 'Lng-6', 'Lng-7', 'Lng-8', 'Lng-9', 'Lng-10', 'Lng-11', 'Lng-12', 'Lng-13'],
        //     'Giraffe' => ['Es', 'Enu', 'Fr', 'Lng-12', 'Lng-13', 'Lng-14', 'Lng-15', 'Lng-16', 'Lng-17', 'Lng-18', 'Lng-19', 'Ar', 'Cs', 'He', 'Hi', 'Ja', 'Lng-1', 'Lng-2', 'Lng-3'],
        //     'Parrot' => ['Lng-14', 'Lng-15', 'Lng-16', 'Lng-17', 'Lng-18', 'Lng-19', 'Ar', 'Cs', 'EnAu', 'En-Gb', 'Es', 'Fr', 'He', 'Hi', 'Ja', 'Lng-1', 'Lng-2', 'Lng-3'],
        //     'Bear' => ['Lng-18', 'Lng-19', 'En-Gb', 'Lng-1', 'Lng-2', 'Lng-3', 'Lng-4', 'Lng-5', 'Lng-6', 'Lng-7', 'Lng-8', 'Lng-9', 'Lng-10', 'Lng-11', 'Lng-12', 'Lng-13', 'Lng-14', 'Lng-15'],
        //     'Bees' => ['Lng-11', 'EnAu', 'Ja', 'Lng-12', 'Lng-13', 'Lng-14', 'Lng-15', 'Lng-16', 'Lng-17', 'Lng-18', 'Lng-19', 'Ar', 'Cs', 'Fr', 'He', 'Hi', 'Ja', 'En-Gb'],
        //     'Lion' => ['Enu', 'Hi', 'Ja', 'Fr', 'Es', 'Lng-1', 'Lng-2', 'Lng-3', 'Lng-4', 'Lng-5', 'Lng-6', 'Lng-7', 'Lng-8', 'Lng-9', 'Lng-10', 'Lng-11', 'Lng-12', 'Lng-13'],
        //     'Zebra' => ['Enu', 'Fr', 'Hi', 'Es', 'Lng-14', 'Lng-15', 'Lng-16', 'Lng-17', 'Lng-18', 'Lng-19', 'Ar', 'Cs', 'He', 'Hi', 'Ja', 'En-Gb', 'Lng-1', 'Lng-2'],
        //     'Rhino' => ['Lng-1', 'Lng-2', 'Lng-3', 'Lng-4', 'Lng-5', 'Lng-6', 'Lng-7', 'Lng-8', 'Lng-9', 'Lng-10', 'Lng-11', 'Lng-12', 'Lng-13', 'Lng-14', 'Lng-15', 'Lng-16', 'Lng-17', 'Lng-18'],
        //     'Fish' => ['Lng-1', 'Lng-2', 'Lng-3', 'Lng-4', 'Lng-5', 'Lng-6', 'Lng-7', 'Lng-8', 'Lng-9', 'Lng-10', 'Lng-11', 'Lng-12', 'Lng-13', 'Lng-14', 'Lng-15', 'Lng-16', 'Lng-17', 'Lng-18'],
        //     'Turtle' => ['Lng-1', 'Lng-2', 'Lng-3', 'Lng-4', 'Lng-5', 'Lng-6', 'Lng-7', 'Lng-8', 'Lng-9', 'Lng-10', 'Lng-11', 'Lng-12', 'Lng-13', 'Lng-14', 'Lng-15', 'Lng-16', 'Lng-17', 'Lng-18'],
        //     'Herons' => ['Lng-1', 'Lng-2', 'Lng-3', 'Lng-4', 'Lng-5', 'Lng-6', 'Lng-7', 'Lng-8', 'Lng-9', 'Lng-10', 'Lng-11', 'Lng-12', 'Lng-13', 'Lng-14', 'Lng-15', 'Lng-16', 'Lng-17', 'Lng-18'],
        //     'WoodPecker' => ['Lng-1', 'Lng-2', 'Lng-3', 'Lng-4', 'Lng-5', 'Lng-6', 'Lng-7', 'Lng-8', 'Lng-9', 'Lng-10', 'Lng-11', 'Lng-12', 'Lng-13', 'Lng-14', 'Lng-15', 'Lng-16', 'Lng-17', 'Lng-18']
        // ];


        return view('admin.animalVdos.index', compact('videos', 'safaries', 'SceneAudios', 'languages'));
    }


    public function create(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'animal_type' => 'required|string|max:255',
            'scene' => 'required|string|max:255|exists:scenes,name',
            'language' => 'required|string|max:255|exists:languages,id',
            'ln_audio' => 'required|file|mimes:mp3,wav,ogg|max:102400',
            'scene_audio' => 'required|exists:scene_audio,id',
            'video_link' => 'required|file|mimes:mp4|max:512000',
        ]);

        try {
            // Process Language Audio
            $lnAudio = uniqid() . '.' . $request->file('ln_audio')->extension();
            $request->file('ln_audio')->move(public_path('LanguageAudio'), $lnAudio);

            // Process Scene Audio
            // $sceneAudio = uniqid() . '.' . $request->file('scene_audio')->extension();
            // $request->file('scene_audio')->move(public_path('SceneAudio'), $sceneAudio);

            // Process Video
            $animalVideo = uniqid() . '.' . $request->file('video_link')->extension();
            $request->file('video_link')->move(public_path('AnimalVideos'), $animalVideo);

            // Save Data to Database
            AnimalVideo::create([
                'animal_type' => $request->animal_type,
                'scene_name' => $request->scene,
                'language' => $request->language,
                'ln_audio' => $lnAudio,
                'scene_audio' => $request->scene_audio,
                'video_link' => $animalVideo,
            ]);

            // Success Response
            return response()->json(['success' => 'Video Uploaded Successfully!']);
        } catch (\Exception $e) {
            // Cleanup uploaded files if necessary
            if (isset($lnAudio))
                unlink(public_path('LanguageAudio/' . $lnAudio));
            if (isset($sceneAudio))
                unlink(public_path('SceneAudio/' . $sceneAudio));
            if (isset($animalVideo))
                unlink(public_path('AnimalVideos/' . $animalVideo));

            // Error Response
            return response()->json(['error' => 'Failed to upload video: ' . $e->getMessage()], 500);
        }
    }


    // public function edit($id)
    // {
    //     $video = AnimalVideo::with('sceneAudio')->findOrFail($id);
    //     return response()->json([
    //         'id' => $video->id,
    //         'scene_name' => $video->scene_name,
    //         'animal_type' => $video->animal_type,
    //         'language' => $video->language,
    //         'video_link' => $video->video_link,
    //         'ln_audio' => $video->ln_audio,
    //         'scene_audio' => $video->sceneAudio ? $video->sceneAudio->id : null, // Return the related SceneAudio ID or null
    //     ]);
    // }

    // public function Update(Request $request, $id)
    // {
    //     $request->validate([
    //         'animal_type' => 'required',
    //         'scene' => 'required',
    //         'language' => 'required',
    //         // 'video_link' => 'file|mimes:mp4',
    //     ]);

    //     $video = AnimalVideo::findOrFail($id);

    //     if ($request->hasFile('video_link')) {
    //         if (file_exists(public_path('AnimalVideos/' . $video->video_link))) {
    //             unlink(public_path('AnimalVideos/' . $video->video_link));
    //         }

    //         $newVideo = uniqid() . '.' . $request->file('video_link')->extension();
    //         $request->file('video_link')->move(public_path('AnimalVideos'), $newVideo);
    //         $video->video_link = $newVideo;
    //     }


    //     //Language Audio
    //     // if ($request->hasFile('ln_audio')) {
    //     //     if (file_exists(public_path('LanguageAudio/' . $video->ln_audio))) {
    //     //         unlink(public_path('LanguageAudio/' . $video->ln_audio));
    //     //     }

    //     $lnAudio = uniqid() . '.' . $request->file('ln_audio')->extension();
    //     $request->file('ln_audio')->move(public_path('LanguageAudio'), $lnAudio);
    //     $video->ln_audio = $lnAudio;
    //     // }
    //     // Handle Scene Audio selection (if applicable)
    //     if ($request->scene_audio) {
    //         $video->scene_audio = $request->scene_audio;
    //     }

    //     $video->animal_type = $request->animal_type;
    //     $video->scene_name = $request->scene;
    //     $video->language = $request->language;

    //     $video->save();

    //     return response()->json([
    //         'success' => 'Video Updated Successfully!'
    //     ]);
    // }



    public function edit($id)
    {
        $video = AnimalVideo::with('sceneAudio')->findOrFail($id);

        return response()->json([
            'id' => $video->id,
            'scene_name' => $video->scene_name,
            'animal_type' => $video->animal_type,
            'language' => $video->language,
            'video_link' => $video->video_link,
            'ln_audio' => $video->ln_audio,
            'scene_audio_id' => optional($video->sceneAudio)->id, // Fetch SceneAudio ID for dropdown
            'scene_audio_file' => optional($video->sceneAudio)->audioFile,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'animal_type' => 'required|string|max:255',
            'scene' => 'required|string|max:255|exists:scenes,name',
            'language' => 'required|string|max:255|exists:languages,id',
            'video_link' => 'nullable|file|mimes:mp4',
            'ln_audio' => 'nullable|file|mimes:mp3,wav',
            'scene_audio' => 'required|string|exists:scene_audio,id'
        ]);

        $video = AnimalVideo::findOrFail($id);

        // Update video file
        if ($request->hasFile('video_link')) {
            $this->deleteFileIfExists(public_path('AnimalVideos/' . $video->video_link));
            $newVideo = uniqid() . '.' . $request->file('video_link')->extension();
            $request->file('video_link')->move(public_path('AnimalVideos'), $newVideo);
            $video->video_link = $newVideo;
        }

        // Update language audio file
        if ($request->hasFile('ln_audio')) {
            $this->deleteFileIfExists(public_path('LanguageAudio/' . $video->ln_audio));
            $newAudio = uniqid() . '.' . $request->file('ln_audio')->extension();
            $request->file('ln_audio')->move(public_path('LanguageAudio'), $newAudio);
            $video->ln_audio = $newAudio;
        }



        // Update other fields
        $video->animal_type = $request->animal_type;
        $video->scene_name = $request->scene;
        $video->language = $request->language;
        $video->scene_audio = $request->scene_audio;

        $video->save();

        return response()->json(['success' => 'Video updated successfully!']);
    }

    private function deleteFileIfExists($filePath)
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function delete($id)
    {
        $animalDelete = AnimalVideo::findOrFail($id);
        unlink(public_path('AnimalVideos/' . $animalDelete->video_link));
        unlink(public_path('LanguageAudio/' . $animalDelete->ln_audio));
        // unlink(public_path('SceneAudio/' . $animalDelete->scene_audio));
        $animalDelete->delete();
        if ($animalDelete) {
            return response()->json([
                'success' => 'Video Deleted Successfully!'
            ]);
        }
    }











    public function videoUpload()
    {
        $availableAnimalTypes = ['Dog', 'Cat', 'Elephant'];

        return view('video-upload', compact('availableAnimalTypes'));
    }
    public function videoUploads(Request $request)
    {
        dd($request->all());
        $request->validate([
            'animal_type' => 'required',
            'video_link' => 'required|mimes:mp4|max:10240',
            'language' => 'required',
        ]);

        $animalVideo = uniqid() . '.' . $request->file('video_link')->extension();

        AnimalVideo::create([
            'animal_type' => $request->animal_type,
            'video_link' => $animalVideo,
            'language' => $request->language,
        ]);

        return redirect()->back()->with('success', 'Video uploaded successfully!');
    }
}