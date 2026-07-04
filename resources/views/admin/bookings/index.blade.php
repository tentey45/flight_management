@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white mb-0 font-heading">Manage Customer Bookings</h2>
    </div>

    <div class="glass-card p-4">
        @if($bookings->isEmpty())
            <div class="text-center py-5">
                <p class="text-muted mb-0">No bookings have been made by customers yet.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-dark table-hover table-glass align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Ticket No.</th>
                            <th>Passenger</th>
                            <th>Flight</th>
                            <th>Route</th>
                            <th>Status</th>
                            <th class="text-end">Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td class="fw-bold text-white">
                                    <span class="text-glow font-monospace">{{ $booking->ticket_number }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-white">{{ $booking->user->name }}</div>
                                    <small class="text-muted">{{ $booking->user->email }}</small>
                                </td>
                                <td>
                                    <span class="flight-tag py-1 px-2 rounded-2">✈ {{ $booking->flight->flight_number }}</span>
                                </td>
                                <td>
                                    <div>From: <strong class="text-white">{{ $booking->flight->departure_location }}</strong></div>
                                    <div>To: <strong class="text-white">{{ $booking->flight->destination }}</strong></div>
                                </td>
                                <td>
                                    <span class="badge-status status-{{ strtolower($booking->status) }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" class="d-inline-flex align-items-center justify-content-end">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm bg-dark text-white border-secondary me-2 w-auto">
                                            <option value="Booking" {{ $booking->status == 'Booking' ? 'selected' : '' }}>Booking</option>
                                            <option value="Confirmed" {{ $booking->status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="Onboard" {{ $booking->status == 'Onboard' ? 'selected' : '' }}>Onboard</option>
                                            <option value="Arrived" {{ $booking->status == 'Arrived' ? 'selected' : '' }}>Arrived</option>
                                            <option value="Completed" {{ $booking->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-glow-blue">Update</button>
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
