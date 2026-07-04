<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_number',
        'departure_location',
        'departure_time',
        'destination',
        'arrival_time',
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
    ];

    /**
     * Get the bookings for the flight.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
