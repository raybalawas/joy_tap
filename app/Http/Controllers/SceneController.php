<?php

namespace App\Http\Controllers;

use App\Models\Scene;
use Illuminate\Http\Request;

class SceneController extends Controller
{
    public function index()
    {
        $scenes = Scene::all();
        return view('scenes.index', compact('scenes'));
    }

    // Show the form to create a new scene
    public function create()
    {
        return view('scenes.create');
    }

    // Store a newly created scene in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Scene::create($request->only('name'));
        return redirect()->route('scenes.index');
    }

    // Show a specific scene
    public function show($id)
    {
        $scene = Scene::findOrFail($id);
        return view('scenes.show', compact('scene'));
    }

    // Show the form to edit a specific scene
    public function edit($id)
    {
        $scene = Scene::findOrFail($id);
        return view('scenes.edit', compact('scene'));
    }

    // Update a specific scene in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $scene = Scene::findOrFail($id);
        $scene->update($request->only('name'));
        return redirect()->route('scenes.index');
    }

    // Remove a specific scene from storage
    public function destroy($id)
    {
        $scene = Scene::findOrFail($id);
        $scene->delete();
        return redirect()->route('scenes.index');
    }
}
