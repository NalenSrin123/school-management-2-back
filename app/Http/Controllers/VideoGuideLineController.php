<?php

namespace App\Http\Controllers;

use App\Models\VideoGuideLine;
use Illuminate\Http\Request;

class VideoGuideLineController extends Controller
{
    // GET all
    public function index()
    {
        $videos = VideoGuideLine::all();

        return response()->json([
            'status' => true,
            'data' => $videos
        ]);
    }

    // POST create
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'file_path' => 'required|string',
            'file_type' => 'required|string',
            'uploaded_by' => 'required|exists:users,id',
            'visibility' => 'nullable|string'
        ]);

        $video = VideoGuideLine::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $request->file_path,
            'file_type' => $request->file_type,
            'uploaded_by' => $request->uploaded_by,
            'upload_date' => now(),
            'visibility' => $request->visibility ?? 'public'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Video guideline created successfully',
            'data' => $video
        ], 201);
    }

    // GET by id
    public function show($id)
    {
        $video = VideoGuideLine::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $video
        ]);
    }

    // PUT update
    public function update(Request $request, $id)
    {
        $video = VideoGuideLine::findOrFail($id);

        $video->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Video guideline updated',
            'data' => $video
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        $video = VideoGuideLine::findOrFail($id);
        $video->delete();

        return response()->json([
            'status' => true,
            'message' => 'Video guideline deleted'
        ]);
    }

    //Show video
    public function latestVideos()
    {
        $videos = VideoGuideLine::latest()->take(8)->get();
        return response()->json($videos);
    }
}
