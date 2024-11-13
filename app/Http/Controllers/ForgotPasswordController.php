<?php

// app/Http/Controllers/ForgotPasswordController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;

use Illuminate\Support\Facades\DB;
class ForgotPasswordController extends Controller
{
    // Step 1: Send Password Reset Link
    public function sendRwesetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Send reset link to the user's email
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Password reset link sent.'], 200)
            : response()->json(['message' => 'Unable to send reset link.'], 500);
    }

    // Step 2: Reset the Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successful.'], 200)
            : response()->json(['message' => 'Invalid token or email.'], 400);
    }






    
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
    
        // Get the user by email
        $user = User::where('email', $request->email)->first();
    
        // Generate the password reset token
        $token = Password::createToken($user);
    
        // Send the custom reset password notification
        $user->notify(new ResetPasswordNotification($token, $request->email));
    
        return response()->json(['message' => 'Password reset link sent.'], 200);
    }
    

}
