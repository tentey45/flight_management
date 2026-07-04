@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <!-- Step Indicator -->
        <div class="d-flex justify-content-between mb-4 border-bottom pb-2">
            <span class="fw-bold text-primary">1. Select Flight</span>
            <span class="fw-bold text-primary">2. Class & Seat</span>
            <span class="text-muted">3. Confirmation</span>
        </div>

        <div class="card mb-4">
            <div class="card-header-blue">
                ✈ Flight Details: {{ $flight->flight_number }}
            </div>
            <div class="card-body">
                <div class="row text-center mb-3">
                    <div class="col">
                        <div class="fw-bold">{{ $flight->departure_location }}</div>
                        <div class="text-muted small">{{ $flight->departure_time->format('M d, Y H:i') }}</div>
                    </div>
                    <div class="col-2 align-self-center text-primary">→</div>
                    <div class="col">
                        <div class="fw-bold">{{ $flight->destination }}</div>
                        <div class="text-muted small">{{ $flight->arrival_time->format('M d, Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('flights.confirm', $flight->id) }}" method="GET">
            <!-- Flight Class Options -->
            <div class="card mb-4">
                <div class="card-header bg-light fw-bold text-dark">
                    Select Your Travel Class
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Economy -->
                        <div class="col-md-4">
                            <label class="d-block p-3 border rounded text-center cursor-pointer h-100" style="background:#f8fafc; border-color:#e2e8f0; cursor: pointer;">
                                <input type="radio" name="class" value="Economy" checked class="form-check-input mb-2" style="transform: scale(1.2);">
                                <div class="fw-bold text-dark">Economy Class</div>
                                <div class="text-primary fw-bold fs-5 mt-1">$299.00</div>
                                <div class="text-muted small mt-2">Standard seats, standard carry-on.</div>
                            </label>
                        </div>
                        <!-- Business -->
                        <div class="col-md-4">
                            <label class="d-block p-3 border rounded text-center cursor-pointer h-100" style="background:#f8fafc; border-color:#e2e8f0; cursor: pointer;">
                                <input type="radio" name="class" value="Business" class="form-check-input mb-2" style="transform: scale(1.2);">
                                <div class="fw-bold text-dark">Business Class</div>
                                <div class="text-primary fw-bold fs-5 mt-1">$599.00</div>
                                <div class="text-muted small mt-2">Priority boarding, extra legroom, meal.</div>
                            </label>
                        </div>
                        <!-- First -->
                        <div class="col-md-4">
                            <label class="d-block p-3 border rounded text-center cursor-pointer h-100" style="background:#f8fafc; border-color:#e2e8f0; cursor: pointer;">
                                <input type="radio" name="class" value="First" class="form-check-input mb-2" style="transform: scale(1.2);">
                                <div class="fw-bold text-dark">First Class</div>
                                <div class="text-primary fw-bold fs-5 mt-1">$999.00</div>
                                <div class="text-muted small mt-2">Luxury suite, fine dining, maximum comfort.</div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seat Selection Grid -->
            <div class="card mb-4">
                <div class="card-header bg-light fw-bold text-dark">
                    Select Your Seat
                </div>
                <div class="card-body text-center">
                    <p class="text-muted small mb-4">Click a seat number from the cabin below to reserve it.</p>
                    
                    <input type="hidden" name="seat_number" id="selected-seat-input" required>
                    
                    <div style="background:#f1f5f9; padding:2rem; border-radius:12px; max-width:400px; margin:0 auto;">
                        <div class="text-muted small border-bottom pb-2 mb-3 fw-bold">✈ COCKPIT / FRONT OF PLANE ✈</div>
                        
                        @php
                            $rows = ['A', 'B', 'C', 'D', 'E'];
                            $cols = [1, 2, 3, 4];
                        @endphp

                        @foreach($rows as $row)
                            <div class="d-flex justify-content-center gap-2 mb-2">
                                @foreach($cols as $col)
                                    @php
                                        $seat = $row . $col;
                                        $isTaken = in_array($seat, $takenSeats);
                                    @endphp

                                    @if($col == 3)
                                        <!-- Aisle Space -->
                                        <div style="width: 20px;"></div>
                                    @endif

                                    <button type="button" 
                                            class="btn btn-sm seat-btn {{ $isTaken ? 'btn-secondary disabled' : 'btn-outline-primary' }}"
                                            style="width: 45px; height: 40px; font-weight: bold; position: relative;"
                                            data-seat="{{ $seat }}"
                                            {{ $isTaken ? 'disabled' : '' }}>
                                        {{ $seat }}
                                    </button>
                                @endforeach
                            </div>
                        @endforeach

                        <div class="text-muted small border-top pt-2 mt-3 fw-bold">REAR OF PLANE</div>
                    </div>

                    <div class="mt-3">
                        Selected Seat: <strong id="selected-seat-badge" class="text-primary fs-5">—</strong>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">← Back to Search</a>
                <button type="submit" id="continue-booking-btn" class="btn btn-primary px-4" disabled>Continue to Confirmation →</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const seatButtons = document.querySelectorAll('.seat-btn:not(.disabled)');
    const input = document.getElementById('selected-seat-input');
    const badge = document.getElementById('selected-seat-badge');
    const submitBtn = document.getElementById('continue-booking-btn');

    seatButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove selection class from others
            seatButtons.forEach(b => {
                b.classList.remove('btn-success');
                b.classList.add('btn-outline-primary');
            });

            // Mark this one as selected
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-success');

            const seat = this.getAttribute('data-seat');
            input.value = seat;
            badge.textContent = seat;
            submitBtn.removeAttribute('disabled');
        });
    });
});
</script>
@endsection
