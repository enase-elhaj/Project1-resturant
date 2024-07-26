<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function getLoggedInUsers()
    {
        // Fetch all logged-in users
        $users = User::where('is_logged_in', true)->get();
        return response()->json($users);
    }
}
