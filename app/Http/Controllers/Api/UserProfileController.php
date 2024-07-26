<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Booking;

class UserProfileController extends Controller
{
    public function mydata()
        {
            $user = User::all();

            return response()->json([
                'user' => $user,
            ], 201);
        }

        public function mybookings()
        {
            $bookings = Booking::all();

            return response()->json([
                'Bookings' => $bookings
            ], 201);
        }
}
