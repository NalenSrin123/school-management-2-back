<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // GET /feedbacks
    public function index()
    {
        $feedback = Feedback::with('user')->latest()->get();
        return response()->json($feedback);
    }

    // POST /feedbacks
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5'
        ]);

        $feedback = Feedback::create($validated);
        return response()->json($feedback, 201);
    }

    // GET /feedbacks/{id}
    public function show($id)
    {
        $feedback = Feedback::with('user')->findOrFail($id);
        return response()->json($feedback);
    }

    // PUT /feedbacks/{id}
    public function update(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);

        $validated = $request->validate([
            'subject' => 'sometimes|string|max:255',
            'message' => 'sometimes|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'status'  => 'sometimes|string|in:Pending,Reviewed,Resolved',
        ]);

        $feedback->update($validated);

        return response()->json($feedback);
    }

    // Delete
    public function destroy($id)
    {
        Feedback::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully!']);
    }
}
