<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnimalVideo;
use App\Models\SceneAudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SceneAudioController extends Controller
{
    /**
     * Display a listing of the scene audios.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $SceneAudios = SceneAudio::all();
        return view('admin.SceneAudio.index', compact('SceneAudios'));
    }

    /**
     * Handle the creation of a new scene audio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'scene_audio' => 'required|file|mimes:mp3,wav,ogg|max:102400', // Ensure |max:102400 it's a valid audio file
        ]);

        // Process and store the uploaded audio file
        $sceneAudioFileName = uniqid() . '.' . $request->file('scene_audio')->extension();
        $request->file('scene_audio')->move(public_path('SceneAudio'), $sceneAudioFileName);

        // if (!$request->file('scene_audio')->isValid()) {
        //     return response()->json(['error' => 'Invalid file upload'], 400);
        // }

        // Save the record in the database
        SceneAudio::create([
            'name' => $request->name,
            'audioFile' => $sceneAudioFileName, // Store the file name
        ]);

        // return redirect()->route('scene.index')->with('success', 'Scene audio uploaded successfully!');
        return response()->json([
            'success' => true,
            'message' => 'Scene audio uploaded successfully!',
        ]);
    }

    /**
     * Show the form for editing the specified scene audio.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $sceneAudio = SceneAudio::findOrFail($id);
        return view('admin.SceneAudio.edit', compact('sceneAudio'));
    }

    /**
     * Handle the update of an existing scene audio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $sceneAudio = SceneAudio::findOrFail($id);

        // Validate the request inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'scene_audio' => 'nullable|file|mimes:mp3,wav,ogg|max:10240', // Optional, only if updating audio file
        ]);

        // Update the name
        $sceneAudio->name = $request->name;

        if ($request->hasFile('edit_audioFile')) {
            // Delete old file if it exists
            $oldFilePath = public_path('SceneAudio/' . $sceneAudio->audioFile);
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
            }

            // Process and store the new audio file
            $sceneAudioFileName = uniqid() . '.' . $request->file('edit_audioFile')->extension();
            $request->file('edit_audioFile')->move(public_path('SceneAudio'), $sceneAudioFileName);

            // Update the audio file name in the database
            $sceneAudio->audioFile = $sceneAudioFileName;
        }

        // Save the updated scene audio record
        $sceneAudio->save();

        return response()->json([
            'success' => true,
            'message' => 'Scene audio updated successfully!',
        ]);
    }

    /**
     * Handle the deletion of a scene audio.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            // Check if the scene audio is being used in any AnimalVideo
            $sceneId = AnimalVideo::where('scene_audio', $id)->first();

            if ($sceneId) {
                // If scene audio is being used, return error response
                return response()->json([
                    'success' => false,
                    'message' => 'This scene audio is currently being used by a video and cannot be deleted.',
                ], 400); // 400 Bad Request
            }

            // Find the SceneAudio record
            $sceneAudio = SceneAudio::findOrFail($id);

            // Delete the audio file from the storage, only if the scene audio is not in use
            $oldFilePath = public_path('SceneAudio/' . $sceneAudio->audioFile);
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
            }

            // Delete the scene audio record from the database
            $sceneAudio->delete();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Scene audio deleted successfully!',
            ], 200); // 200 OK
        } catch (\Exception $e) {
            // Handle any unexpected errors
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the scene audio: ' . $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }

}