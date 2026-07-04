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
     * Show search page and search results.
     */
    public function search(Request $request)
    {
        $departure = $request->input('departure');
        $destination = $request->input('destination');
        $date = $request->input('date');

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

        // Get matching flights
        $flights = $query->orderBy('departure_time', 'asc')->get();

        // Get unique departures and destinations for quick filters
        $allDepartures = Flight::select('departure_location')->distinct()->pluck('departure_location');
        $allDestinations = Flight::select('destination')->distinct()->pluck('destination');

        return view('flights.search', compact('flights', 'departure', 'destination', 'date', 'allDepartures', 'allDestinations'));
    }

    /**
     * Store a new booking for a flight.
     */
    public function book(Request $request, Flight $flight)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to book a flight.');
        }

        $user = Auth::user();

        // Generate unique ticket number: FL-YYYYMMDD-XXXXXX
        do {
            $ticketNumber = 'FL-' . Carbon::now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Booking::where('ticket_number', $ticketNumber)->exists());

        // Create booking
        Booking::create([
            'user_id' => $user->id,
            'flight_id' => $flight->id,
            'ticket_number' => $ticketNumber,
            'status' => 'Booking',
        ]);

        return redirect()->route('profile')->with('success', 'Flight booked successfully! Your ticket number is ' . $ticketNumber);
    }
}
