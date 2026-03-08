<?php

namespace App\Otp;

use SadiqSalau\LaravelOtp\Contracts\OtpInterface as Otp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserRegistrationOtp implements Otp
{
  public function __construct(
    public string $name,
    public string $email,
    public string $password
  ) {}

  /**
   * This method is called when OTP is successfully verified
   * Process the OTP - create user and log them in
   */
  public function process(): mixed
  {
    // Create the user
    $user = User::create([
      'name' => $this->name,
      'email' => $this->email,
      'password' => Hash::make($this->password),
      'email_verified_at' => now(),
      'role_id' => 2, // Default role (adjust based on your roles table)
      'is_active' => true,
    ]);

    // Log the user in
    Auth::login($user);

    // Return user data (this will be in the 'result' key)
    return [
      'user' => $user,
      'token' => $user->createToken('auth-token')->plainTextToken // If using Sanctum
    ];
  }
}
