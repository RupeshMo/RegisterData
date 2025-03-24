<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show the registration form (this could return a Blade view)
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle the registration logic
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create a Sanctum token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        return view('auth.register', [
            'success' => 'Registration successful. You can now log in.',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login logic
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            // Redirect to /registerdata after successful login
            return redirect()->route('registerdata')->with([
                'success' => 'Login successful. Welcome back!',
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    // Handle logout logic
    public function logout(Request $request)
    {
        // Revoke the user's current token
        $request->user()->currentAccessToken()->delete();

        return redirect()->route('login')->with([
            'success' => 'Logged out successfully.',
        ]);
    }
}
