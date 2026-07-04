@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Manage Bookings & Trip Status</h4>
    <span class="badge bg-secondary fs-6">{{ $bookings->count() }} total</span>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Ticket #</th>
                        <th>Passenger</th>
                        <th>Flight</th>
                        <th>Class & Seat</th>
                        <th>Route</th>
                        <th>Departure</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>
                                <code style="font-size:0.8rem;">{{ $booking->ticket_number }}</code>
                            </td>
                            <td>
                                <div style="font-weight:600;">{{ $booking->user->name }}</div>
                                <div class="text-muted" style="font-size:0.8rem;">{{ $booking->user->email }}</div>
                            </td>
                            <td><span class="badge bg-primary">{{ $booking->flight->flight_number }}</span></td>
                            <td>
                                <div class="fw-semibold" style="font-size:0.85rem;">{{ $booking->class }}</div>
                                <div class="text-success small fw-bold">Seat {{ $booking->seat_number ?? '—' }}</div>
                            </td>
                            <td>
                                <span style="font-size:0.85rem;">
                                    {{ $booking->flight->departure_location }}
                                    → {{ $booking->flight->destination }}
                                </span>
                            </td>
                            <td style="font-size:0.85rem;">{{ $booking->flight->departure_time->format('M d, Y H:i') }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($booking->status) }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" class="d-flex gap-1">
                                    @csrf @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" style="width:120px;">
                                        @foreach(['Booking','Confirmed','Onboard','Arrived','Completed'] as $st)
                                            <option value="{{ $st }}" {{ $booking->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No bookings yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
