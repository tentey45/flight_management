<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class AdminFlightController extends Controller
{
    public function index()
    {
        $flights = Flight::latest()->get();
        return view('admin.flights.index', compact('flights'));
    }

    public function create()
    {
        return view('admin.flights.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'flight_number' => 'required|string|max:20|unique:flights,flight_number',
            'departure_location' => 'required|string|max:100',
            'departure_time' => 'required|date',
            'destination' => 'required|string|max:100|different:departure_location',
            'arrival_time' => 'required|date|after:departure_time',
        ]);

        Flight::create($validated);

        return redirect()->route('admin.flights.index')->with('success', 'Flight created successfully.');
    }

    public function edit(Flight $flight)
    {
        return view('admin.flights.edit', compact('flight'));
    }

    public function update(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'flight_number' => 'required|string|max:20|unique:flights,flight_number,' . $flight->id,
            'departure_location' => 'required|string|max:100',
            'departure_time' => 'required|date',
            'destination' => 'required|string|max:100|different:departure_location',
            'arrival_time' => 'required|date|after:departure_time',
        ]);

        $flight->update($validated);

        return redirect()->route('admin.flights.index')->with('success', 'Flight updated successfully.');
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();

        return redirect()->route('admin.flights.index')->with('success', 'Flight deleted successfully.');
    }
}
