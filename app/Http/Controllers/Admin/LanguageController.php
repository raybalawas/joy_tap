<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnimalVideo;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return view('admin.language.index', compact('languages'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'regex:/^[A-Za-z\s]+$/']
        ]);

        Language::create([
            'name' => $request->name,
        ]);
        return response()->json(['status' => true, 'message' => 'Language Created successfully!']);

        // return redirect()->route('language.index')->with('success', 'Language added successfully!');
    }

    public function edit($id)
    {
        $language = Language::findOrFail($id);
        return response()->json($language);
    }

    public function update(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'name' => ['required', 'string', 'regex:/^[A-Za-z\s]+$/']

        ]);

        // Find the language by ID
        $language = Language::findOrFail($id);

        // Update the language name
        $language->update([
            'name' => $request->name,
        ]);


        // Return a success response
        return response()->json(['message' => 'Language updated successfully!']);
    }



    public function destroy($id)
    {
        $language = Language::findOrFail($id);

        $lanExistAnimalVideo = AnimalVideo::where('language', $id)->exists();
        $lanExistUser = User::where('language', $id)->exists();

        if ($lanExistAnimalVideo) {
            return response()->json([
                'status' => false,
                'message' => 'Cannot delete language because it is associated with an animal video.'
            ]);
        }

        if ($lanExistUser) {
            return response()->json([
                'status' => false,
                'message' => 'Cannot delete language because it is associated with a user.'
            ]);
        }

        $language->delete();

        return response()->json([
            'status' => true,
            'message' => 'Language deleted successfully!'
        ]);
    }

}
