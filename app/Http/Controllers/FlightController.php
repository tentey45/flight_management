<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FlightController extends Controller
{
    /**
     * Show search page and search results (homepage).
     */
    public function search(Request $request)
    {
        $departure   = $request->input('departure');
        $destination = $request->input('destination');
        $date        = $request->input('date');

        $query = Flight::query();

        if ($departure) {
            $query->where('departure_location', 'like', '%' . $departure . '%');
        }
        if ($destination) {
            $query->where('destination', 'like', '%' . $destination . '%');
        }
        if ($date) {
            $query->whereDate('departure_time', Carbon::parse($date)->toDateString());
        }

        $flights         = $query->orderBy('departure_time', 'asc')->get();
        $allDepartures   = Flight::select('departure_location')->distinct()->pluck('departure_location');
        $allDestinations = Flight::select('destination')->distinct()->pluck('destination');

        return view('flights.search', compact('flights', 'departure', 'destination', 'date', 'allDepartures', 'allDestinations'));
    }

    /**
     * Step 1b — Show class & seat selection page.
     */
    public function showSelect(Flight $flight)
    {
        // Already-taken seats for this flight
        $takenSeats = Booking::where('flight_id', $flight->id)
            ->whereNotNull('seat_number')
            ->pluck('seat_number')
            ->toArray();

        return view('flights.select', compact('flight', 'takenSeats'));
    }

    /**
     * Step 2 — Show booking confirmation page.
     * Receives class & seat as query-string params from the select form.
     */
    public function showConfirm(Request $request, Flight $flight)
    {
        $request->validate([
            'class'       => 'required|in:Economy,Business,First',
            'seat_number' => 'nullable|string|max:5',
        ]);

        $selectedClass = $request->input('class');
        $seatNumber    = $request->input('seat_number');

        $prices = ['Economy' => 299, 'Business' => 599, 'First' => 999];
        $price  = $prices[$selectedClass];

        return view('flights.confirm', compact('flight', 'selectedClass', 'seatNumber', 'price'));
    }

    /**
     * Step 3 — Create the booking in the database.
     */
    public function book(Request $request, Flight $flight)
    {
        $request->validate([
            'class'       => 'required|in:Economy,Business,First',
            'seat_number' => 'nullable|string|max:5',
        ]);

        $user = Auth::user();

        // Generate unique ticket number: FL-YYYYMMDD-XXXXXX
        do {
            $ticketNumber = 'FL-' . Carbon::now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Booking::where('ticket_number', $ticketNumber)->exists());

        Booking::create([
            'user_id'      => $user->id,
            'flight_id'    => $flight->id,
            'ticket_number'=> $ticketNumber,
            'status'       => 'Booking',
            'class'        => $request->input('class'),
            'seat_number'  => $request->input('seat_number'),
        ]);

        return redirect()->route('profile')
            ->with('success', 'Booking confirmed! 🎉 Your ticket number is ' . $ticketNumber);
    }
}
