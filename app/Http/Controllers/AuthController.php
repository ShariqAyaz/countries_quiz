<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    
    public function autoLogin(Request $request)
    {
        
        $user = User::where('email', 'test@example.com')->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Log in the user
        Auth::login($user);

        return response()->json(['message' => 'User auto-logged in.'], 200);
    }

    /**
     * Optional: Logout endpoint
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully.'], 200);
    }
}
