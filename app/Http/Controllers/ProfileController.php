<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the user's profile with bookings and tickets.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Retrieve bookings with flight details
        $bookings = $user->bookings()->with('flight')->latest()->get();

        return view('profile', compact('user', 'bookings'));
    }
}
