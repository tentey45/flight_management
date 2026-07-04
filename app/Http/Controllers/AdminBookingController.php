<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'flight'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:Booking,Confirmed,Onboard,Arrived,Completed',
        ]);

        $booking->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking status updated successfully.');
    }
}
