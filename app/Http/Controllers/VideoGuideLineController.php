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
        try {
            // ✅ Validate input
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'file_path' => 'required|url', // if using YouTube link
                'file_type' => 'required',
                // 'file_type' => 'required|in:video,youtube,upload',
                'uploaded_by' => 'required|exists:users,id',
                'visibility' => 'nullable|in:public,private'
            ]);

            // ✅ Create video using validated data
            $video = VideoGuideLine::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'file_path' => $validated['file_path'],
                'file_type' => $validated['file_type'],
                'uploaded_by' => $validated['uploaded_by'],
                'upload_date' => now(),
                'visibility' => $validated['visibility'] ?? 'public'
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Video guideline created successfully',
                'data' => $video
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Server error',
                'error' => $th->getMessage()
            ], 500);
        }
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
