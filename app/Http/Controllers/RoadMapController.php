<?php

namespace App\Http\Controllers;

use App\Models\RoadMap;
use Illuminate\Http\Request;

class RoadMapController extends Controller
{
    // Show all
    public function index()
    {
        return response()->json(RoadMap::all());
    }

    // Create
    public function store(Request $request)
    {
        $roadmap = RoadMap::create($request->all());
        return response()->json($roadmap, 201);
    }

    // Show by ID
    public function show($id)
    {
        return response()->json(RoadMap::findOrFail($id));
    }

    // Update
    public function update(Request $request, $id)
    {
        $roadmap = RoadMap::findOrFail($id);
        $roadmap->update($request->all());
        return response()->json($roadmap);
    }

    // Delete
    public function destroy($id)
    {
        RoadMap::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
