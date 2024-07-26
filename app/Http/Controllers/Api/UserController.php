<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; 

use Illuminate\Validation\Rule;

use App\Models\User;



class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }
    /////////the one working goooood
    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required',
    //         'password' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $user = User::where('email', $request->email)->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         return response()->json(['message' => 'Invalid credentials'], 401);
    //     }

    //     // $token = $user->createToken('auth_token')->plainTextToken;
    //     // return response()->json(['message' => 'Login successful', 'token' => $token], 200);
    //     return response()->json(['message' => 'Login successful'], 200);
    // }
    //////////////////the one I am trying now

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        Auth::user()->update(['is_logged_in' => true]);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
        
    }
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //         $user = Auth::user();
    //         $token = $user->createToken('authToken')->plainTextToken;
    //         Auth::user()->update(['is_logged_in' => true]);

    //         return response()->json(['token' => $token], 200);
            
    //     }

    //     return response()->json(['error' => 'Unauthorized'], 401);
    // }

    // {
    //     $credentials = $request->only('email', 'password');
    
    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    //         $user->is_logged_in = true;
    //         $user->save();
    
    //         // Generate token or return response
    //         // ...
    
    //         return response()->json(['message' => 'Login successful']);
    //     }
    
    //     return response()->json(['message' => 'Invalid credentials'], 401);
    // }

  


    // public function profile(Request $request)
    // {
    //     return response()->json($request->user());
    // }

    // public function update(Request $request)
    // {
    //     $request->validate([
            
    //         'email' => ['required', 'email', Rule::unique('users')->ignore($request->user()->id)],
    //         'password' => ['nullable', 'min:8'],
            
    //     ]);

    //     $user = $request->user();
    //     $user->email = $request->email;

    //     if ($request->password) {
    //         $user->password = Hash::make($request->password);
    //     }

    //     $user->save();

    //     return response()->json($user);
    // }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            if ($user) {
                \Log::info('User before logout:', ['id' => $user->id, 'is_logged_in' => $user->is_logged_in]);
    
                $user->currentAccessToken()->delete();
                
                // Manually fetch and update the user
                $updatedUser = User::find($user->id);
                $updatedUser->is_logged_in = false;
                $updatedUser->save();
    
                \Log::info('User after logout:', ['id' => $updatedUser->id, 'is_logged_in' => $updatedUser->is_logged_in]);
    
                return response()->json(['message' => 'Logged out successfully']);
            }
    
            return response()->json(['message' => 'User not authenticated'], 401);
        } catch (\Exception $e) {
            \Log::error('Logout error: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while logging out'], 500);
        }
        
}

    public function all()
    {
        $users = User::all();
        return response()->json($users);
    }

    
}

