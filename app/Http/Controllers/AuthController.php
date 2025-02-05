<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\utilities\helper;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // Attempt to generate a token using the provided credentials
            if (!$token = JWTAuth::attempt($credentials)) {
                return redirect()->back()->with('error', 'Invalid credentials');
            }
            // Store the token in the session
            session(['jwt_token' => $token]);
            $user = helper::getTokenInfo();
           // Log::info($user);
            if($user &&  $user->type == 1){
                return redirect()->route('adminDashboard');
            }else{
                return redirect()->route('dashboard');
            }
            
            
        } catch (JWTException $e) {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function logout()
    {
        $token = session('jwt_token'); // Get token from the session

        if (!$token) {
            return response()->json(['error' => 'Token not found'], 400); // Handle case where token is missing
        }

        try {
            JWTAuth::setToken($token)->invalidate(); // Invalidate the token
            session()->forget('jwt_token'); // Remove the token from session
            return redirect()->route('login');
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout'], 500); // Handle logout failure
        }
    }

    // Refresh Token
    public function refresh()
    {
        return response()->json(['token' => JWTAuth::refresh(JWTAuth::getToken())]);
    }

    // Get Authenticated User
    public function profile()
    {
        return response()->json(JWTAuth::user());
    }
}
