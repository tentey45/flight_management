@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white mb-0 font-heading">Manage Flights</h2>
        <a href="{{ route('admin.flights.create') }}" class="btn btn-glow">+ Add New Flight</a>
    </div>

    <div class="glass-card p-4">
        @if($flights->isEmpty())
            <div class="text-center py-5">
                <p class="text-muted mb-0">No flights in database yet. Click "Add New Flight" to get started.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-dark table-hover table-glass align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Flight No.</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($flights as $flight)
                            <tr>
                                <td class="fw-bold text-white">
                                    <span class="flight-tag py-1 px-2 rounded-2">✈ {{ $flight->flight_number }}</span>
                                </td>
                                <td>{{ $flight->departure_location }}</td>
                                <td>{{ $flight->destination }}</td>
                                <td>
                                    <div class="fw-bold text-white">{{ $flight->departure_time->format('H:i') }}</div>
                                    <small class="text-muted">{{ $flight->departure_time->format('D, M d Y') }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold text-white">{{ $flight->arrival_time->format('H:i') }}</div>
                                    <small class="text-muted">{{ $flight->arrival_time->format('D, M d Y') }}</small>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.flights.edit', $flight->id) }}" class="btn btn-sm btn-outline-info me-2">Edit</a>
                                    <form action="{{ route('admin.flights.destroy', $flight->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this flight? All associated bookings will be lost.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
