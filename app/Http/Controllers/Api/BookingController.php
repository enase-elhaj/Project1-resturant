<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function store(Request $request){
        // Define validation rules
        $validator = Validator::make($request->all(), [
            // 'id'=>'required',
            // 'user_id' => 'required',
            // 'user_id' => 'required|exists:users,id',///////////////////
            'date' => 'required|date',
            'time' => 'required',
            'nameb' => 'required|string',
            'phone' => 'required|string',
            'persons' => 'required|integer'
        ]);
        // $validator['user_id']=auth()->user()->id; 
        // Check for validation errors
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create the booking
        $booking = Booking::create([
            // 'id'=>$request->id,
            // 'user_id' => $request->user_id,////////////////////////////
            'user_id' => auth()->id(),
            'date' => $request->date,
            'time' => $request->time,
            'nameb' => $request->nameb,
            'phone' => $request->phone,
            'persons' => $request->persons
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'data' => $booking
        ], 201);
    }

    public function index()
        {
            $bookings = Booking::all();
            return response()->json($bookings);
        }


        public function destroy($id)
        {
            $booking = Booking::find($id);
            if ($booking) {
                $booking->delete();
                return response()->json(['message' => 'Booking deleted successfully'], 200);
            }
            return response()->json(['message' => 'Booking not found'], 404);
        }

        public function approve($id)

    {
        $booking = Booking::find($id);
        if ($booking) {
            $booking->status = 'approved'; // Update status to 'approved'
            $booking->save();
            return response()->json(['message' => 'Booking approved successfully'], 200);
        }
        return response()->json(['message' => 'Booking not found'], 404);
    }

    public function reject($id)
    {
        $booking = Booking::find($id);
        if ($booking) {
            $booking->status = 'rejected'; // Update status to 'rejected'
            $booking->save();
            return response()->json(['message' => 'Booking rejected successfully'], 200);
        }
        return response()->json(['message' => 'Booking not found'], 404);
    }

    // public function indexp()
    // {
    //     $bookings = Booking::where('user_id', auth()->id())->get();
    //     return response()->json(['bookings' => $bookings], 200);
    // }
}
