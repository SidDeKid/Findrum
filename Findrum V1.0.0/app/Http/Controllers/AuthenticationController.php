<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;

class AuthenticationController extends Controller {
    public function register(Request $request) {
        try {
            $attr = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed'
            ]);
            $user = User::create([
                'name' => $attr['name'],
                'password' => bcrypt($attr['password']),
                'email' => $attr['email']
            ]);    
        } catch (\Throwable $th) {
            Log::error("Error caught while trying to register new user." + $th);
            return response()->json(['message' => 'Registration unsuccessful'], 403);
        }
        return response()->json(['message' => 'Registration successful'], 200);
    }
    
    public function login(Request $request) {
        try {
            $attr = $request->validate([
                'email' => 'required|string|email|',
                'password' => 'required|string|min:6'
            ]);
            if (!Auth::attempt($attr)) {
                Log::warning("user $request[email] failed logging in. Credentials dit not match.");
                return response()->json(['message' => 'Credentials not match'], 401);
            }
            $response = [
                'access_token' => auth()->user()->createToken('API Token')->plainTextToken,
                'token_type' => 'Bearer'
            ];
        } catch (\Throwable $th) {
            Log::error("Error caught while trying to log in user." + $th);
            return response()->json(['message' => 'Log in unsuccessful'], 403);
        }
        return response()->json($response, 200);
    }

    public function logout() {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Tokens Revoked'], 200);
    }
}