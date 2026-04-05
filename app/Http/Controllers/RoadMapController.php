<?php

namespace App\Http\Controllers;

use App\Models\RoadMap;
use Illuminate\Http\Request;

class RoadMapController extends Controller
{
    // GET /roadmaps
    public function index()
    {
        return response()->json(RoadMap::all());
    }

    // POST /roadmaps
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $path = $request->file('image')->store('roadmaps', 'public');

        $roadmap = RoadMap::create([
            'image' => asset('storage/' . $path),
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json($roadmap, 201);
    }

    // GET /roadmaps/{id}
    public function show($id)
    {
        return response()->json(RoadMap::findOrFail($id));
    }

    // PUT /roadmaps/{id}
    public function update(Request $request, $id)
    {
        $roadmap = RoadMap::findOrFail($id);

        $data = [];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('roadmaps', 'public');
            $data['image'] = asset('storage/' . $path);
        }

        if ($request->filled('title')) $data['title'] = $request->title;
        if ($request->filled('description')) $data['description'] = $request->description;

        $roadmap->update($data);
        return response()->json($roadmap);
    }

    // DELETE /roadmaps/{id}
    public function destroy($id)
    {
        RoadMap::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
