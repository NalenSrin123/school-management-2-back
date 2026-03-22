<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Exception;


class CourseController extends Controller
{

    // Get all courses
    public function index()
    {
        try {
            $courses = Course::all();

            return response()->json([
                'success' => true,
                'data' => $courses
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Create course
    public function store(Request $request)
    {
        try {

            $course = Course::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $request->image
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Course created successfully',
                'data' => $course
            ]);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Get one course
    public function show($id)
    {
        try {

            $course = Course::findOrFail($id);

            $course->increment('views');

            return response()->json([
                'success' => true,
                'data' => $course->fresh()
            ]);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Course not found'
            ], 404);
        }
    }

    // Update course
    public function update(Request $request, $id)
    {
        try {

            $course = Course::findOrFail($id);

            $course->update([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $request->image
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Course updated successfully',
                'data' => $course
            ]);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Delete course
    public function destroy($id)
    {
        try {

            $course = Course::findOrFail($id);
            $course->delete();

            return response()->json([
                'success' => true,
                'message' => 'Course deleted successfully'
            ]);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Get all courses sorted by most views
    public function mostViewed()
    {
        try {
            $courses = Course::orderBy('views', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $courses
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
