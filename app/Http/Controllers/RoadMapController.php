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
        $validated = $request->validate([
            'image' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $roadmap = RoadMap::create($validated);
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

        $validated = $request->validate([
            'image' => 'sometimes|string',
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
        ]);

        $roadmap->update($validated);
        return response()->json($roadmap);
    }

    // DELETE /roadmaps/{id}
    public function destroy($id)
    {
        RoadMap::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
