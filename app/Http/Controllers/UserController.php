<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Plucked out the query() as it's not strictly needed when using with()
        $users = User::with('role')->latest()->paginate(10);

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8',
            // Changed to an integer instead of an array since a user has one role
            'role_id'   => 'required|integer|exists:roles,id', 
            // Nullable so if they don't send it, it won't fail validation
            'is_active' => 'nullable|boolean', 
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'password'  => bcrypt($validated['password']),
                'role_id'   => $validated['role_id'],
                // If they didn't provide is_active, default it to true
                'is_active' => $validated['is_active'] ?? true, 
            ]);

            DB::commit();

            return response()->json([
                'message' => 'User Created Successfully',
                'data'    => $user->load('role'), // Singular 'role' to match index method
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while creating the user.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('role')->findOrFail($id);

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:8',
            'role_id'   => 'required|integer|exists:roles,id',
            'is_active' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $dataToUpdate = [
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'role_id'   => $validated['role_id'],
                'is_active' => $validated['is_active'],
            ];

            // Only update the password if a new one was actually provided
            if (!empty($validated['password'])) {
                $dataToUpdate['password'] = bcrypt($validated['password']);
            }

            $user->update($dataToUpdate);

            DB::commit();

            return response()->json([
                'message' => 'User Updated Successfully',
                'data'    => $user->load('role'),
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User update failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while updating the user.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        try {
            $user->delete();

            return response()->json([
                'message' => 'User Deleted Successfully',
            ], 200);

        } catch (\Exception $e) {
            Log::error('User deletion failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while deleting the user.',
            ], 500);
        }
    }
}