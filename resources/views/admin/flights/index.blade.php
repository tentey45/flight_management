@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Manage Flights</h4>
    <a href="{{ route('admin.flights.create') }}" class="btn btn-primary">+ Add New Flight</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Flight No.</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($flights as $flight)
                        <tr>
                            <td><span class="badge bg-primary">{{ $flight->flight_number }}</span></td>
                            <td>{{ $flight->departure_location }}</td>
                            <td>{{ $flight->destination }}</td>
                            <td>{{ $flight->departure_time->format('M d, Y H:i') }}</td>
                            <td>{{ $flight->arrival_time->format('M d, Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.flights.edit', $flight->id) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                                <form action="{{ route('admin.flights.destroy', $flight->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this flight?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No flights in the system yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
