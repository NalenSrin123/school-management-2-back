<?php

namespace App\Http\Controllers;

use App\Models\ProfileSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileSchoolController extends Controller
{
    // GET ALL - return only image URLs
    public function index()
    {
        try {
            $data = ProfileSchool::all()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'image' => $item->image ? asset('storage/' . $item->image) : null,
                ];
            });

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // STORE new image
    public function store(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            // Upload image
            $path = $request->file('image')->store('profile_schools', 'public');

            $data = ProfileSchool::create([
                'image' => $path,
            ]);

            return response()->json([
                'id' => $data->id,
                'image' => asset('storage/' . $data->image),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // SHOW single image
    public function show($id)
    {
        try {
            $item = ProfileSchool::findOrFail($id);

            return response()->json([
                'id' => $item->id,
                'image' => $item->image ? asset('storage/' . $item->image) : null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    // UPDATE image
    public function update(Request $request, $id)
    {
        try {
            $data = ProfileSchool::findOrFail($id);

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($data->image && Storage::disk('public')->exists($data->image)) {
                    Storage::disk('public')->delete($data->image);
                }

                // Upload new image
                $path = $request->file('image')->store('profile_schools', 'public');
                $data->image = $path;
                $data->save();
            }

            return response()->json([
                'id' => $data->id,
                'image' => asset('storage/' . $data->image),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // DELETE image
    public function destroy($id)
    {
        try {
            $data = ProfileSchool::findOrFail($id);

            // Delete image from storage
            if ($data->image && Storage::disk('public')->exists($data->image)) {
                Storage::disk('public')->delete($data->image);
            }

            $data->delete();

            return response()->json([
                'message' => 'Deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
