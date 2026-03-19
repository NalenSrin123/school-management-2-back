<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;
use SadiqSalau\LaravelOtp\Facades\Otp;
use App\Otp\UserRegistrationOtp;

class OtpController extends Controller
{
  /**
   * Register user and send OTP
   */
  public function register(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
      'password' => ['required', Rules\Password::defaults()],
    ]);

    // Send OTP with user data
    $otp = Otp::identifier($request->email)->send(
      new UserRegistrationOtp(
        name: $request->name,
        email: $request->email,
        password: $request->password
      ),
      Notification::route('mail', $request->email)
    );

    return response()->json([
      'success' => true,
      'message' => __($otp['status']),
      'data' => [
        'email' => $request->email
      ]
    ], 200);
  }

  /**
   * Verify OTP and process (create user)
   */
  public function verifyOtp(Request $request)
  {
    $request->validate([
      'email' => ['required', 'string', 'email', 'max:255'],
      'code' => ['required', 'string']
    ]);

    $otp = Otp::identifier($request->email)->attempt($request->code);

    if ($otp['status'] != Otp::OTP_PROCESSED) {
      return response()->json([
        'success' => false,
        'message' => __($otp['status'])
      ], 403);
    }

    // Return the result from the process() method
    return response()->json([
      'success' => true,
      'message' => 'OTP verified successfully',
      'data' => $otp['result']
    ], 200);
  }

  /**
   * Resend OTP
   */
  public function resendOtp(Request $request)
  {
    $request->validate([
      'email' => ['required', 'string', 'email', 'max:255']
    ]);

    // If the user already exists, they have completed registration;
    // there is no registration OTP to resend.
    if (User::where('email', $request->email)->exists()) {
      return response()->json([
        'success' => false,
        'message' => 'User is already verified. Please log in instead of requesting a new registration OTP.',
      ], 400);
    }

    $otp = Otp::identifier($request->email)->update();

    if ($otp['status'] != Otp::OTP_SENT) {
      return response()->json([
        'success' => false,
        'message' => $otp['status'] === 'otp.empty'
          ? 'No active OTP found to resend. Please call the registration endpoint again to generate a new OTP.'
          : __($otp['status'])
      ], 403);
    }

    return response()->json([
      'success' => true,
      'message' => __($otp['status']),
      'data' => [
        'email' => $request->email
      ]
    ], 200);
  }
}
