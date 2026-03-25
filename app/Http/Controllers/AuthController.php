<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    //register
   public function register(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',

                'role_id' => 'sometimes|exists:roles,id',
            ]);

            
            $role_id = $validated['role_id'] ?? 2;


            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $role_id,
                'is_active' => true,
                'remember_token' => Str::random(10),
            ]);


            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Register successfully',
                'data' => $user,
                'token' => $token
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request){
        try{
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::query()->where('email', $request->input('email'))->first();

        if(!$user || !Hash::check($request->input('password'), $user->password)){
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'=> 'login successfully',
            'token' => $token,
            'user' => $user
        ], 200);

        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function sendOtp(Request $request)
    {
        try {
            // 1. Validate that the email is provided and exists in the users table
            $request->validate([
                'email' => 'required|email|exists:users,email'
            ]);

            $email = $request->input('email');

            // 2. Generate a random 6-digit OTP
            $otp = rand(100000, 999999);

            // 3. Store the OTP in the Cache for 5 minutes
            // We use the email as the cache key so we can look it up later
            Cache::put('otp_' . $email, $otp, now()->addMinutes(5));

            // 4. Send the OTP via Email
            // Note: For production, it is better to create a Mailable class (e.g., php artisan make:mail OtpMail)
            Mail::raw("Your OTP for login is: $otp. It will expire in 5 minutes.", function ($message) use ($email) {
                $message->to($email)
                        ->subject('Your Login OTP');
            });

            return response()->json([
                'message' => 'OTP sent successfully. Please check your email.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send OTP: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'otp' => 'required|numeric'
            ]);

            $cachedOtp = Cache::get('otp_' . $request->email);

            // Check if OTP exists and matches
            if (!$cachedOtp || $cachedOtp != $request->otp) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid or expired OTP'
                ], 401);
            }

            // Clear the OTP from cache so it can't be reused
            Cache::forget('otp_' . $request->email);

            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'OTP verified successfully',
                'data' => $user,
                'token' => $token
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


}

