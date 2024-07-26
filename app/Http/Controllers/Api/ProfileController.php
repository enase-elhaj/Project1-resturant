<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Models\Booking;
// use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return response()->json($user);
    }
//////////////////////////////////////////////////////////////////////
    // public function update(Request $request)
    // {
    //     $user = Auth::user();
    //     $user->update($request->only('name', 'email'));

    //     return response()->json([
    //         'user' => $user,
    //         'message' => 'Profile updated successfully',
    //     ]);
    // }
    //////////////////////////////////////////////////////////////

    public function update(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get authenticated user
            $user = Auth::user();

            // Update user profile
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }
        // $user = Auth::user();
        
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        //     // Add other fields you want to update
        // ]);

        // $user->name = $request->name;
        // $user->email = $request->email;
        // // Update other fields as needed
        // $user->save();

        // return response()->json(['message' => 'Profile updated successfully', 'user' => $user], 200);
    

    public function bookings(Request $request)
    {
        $user = Auth::user();
        $bookings = $user->bookings; // Assuming User model has 'bookings' relationship
        return response()->json($bookings);
    }
}
