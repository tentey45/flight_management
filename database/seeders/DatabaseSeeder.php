<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Flight;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::updateOrCreate(
            ['email' => 'admin@flight.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // 2. Seed Customer Users
        User::updateOrCreate(
            ['email' => 'customer@flight.com'],
            [
                'name' => 'Customer User',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        User::updateOrCreate(
            ['email' => 'user2@flight.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        // 3. Seed Sample Flights
        $flights = [
            [
                'flight_number' => 'JL-006',
                'departure_location' => 'Tokyo (NRT)',
                'departure_time' => Carbon::now()->addDay()->setTime(10, 0),
                'destination' => 'New York (JFK)',
                'arrival_time' => Carbon::now()->addDay()->setTime(22, 30),
            ],
            [
                'flight_number' => 'BA-308',
                'departure_location' => 'London (LHR)',
                'departure_time' => Carbon::now()->addDays(2)->setTime(8, 0),
                'destination' => 'Paris (CDG)',
                'arrival_time' => Carbon::now()->addDays(2)->setTime(9, 15),
            ],
            [
                'flight_number' => 'QF-012',
                'departure_location' => 'Los Angeles (LAX)',
                'departure_time' => Carbon::now()->addDays(3)->setTime(23, 0),
                'destination' => 'Sydney (SYD)',
                'arrival_time' => Carbon::now()->addDays(5)->setTime(6, 30),
            ],
            [
                'flight_number' => 'EK-652',
                'departure_location' => 'Dubai (DXB)',
                'departure_time' => Carbon::now()->addDays(4)->setTime(14, 0),
                'destination' => 'Maldives (MLE)',
                'arrival_time' => Carbon::now()->addDays(4)->setTime(18, 30),
            ],
            [
                'flight_number' => 'SQ-938',
                'departure_location' => 'Singapore (SIN)',
                'departure_time' => Carbon::now()->addDays(5)->setTime(11, 30),
                'destination' => 'Bali (DPS)',
                'arrival_time' => Carbon::now()->addDays(5)->setTime(14, 15),
            ],
            [
                'flight_number' => 'LH-430',
                'departure_location' => 'Frankfurt (FRA)',
                'departure_time' => Carbon::now()->addDays(6)->setTime(9, 45),
                'destination' => 'Chicago (ORD)',
                'arrival_time' => Carbon::now()->addDays(6)->setTime(18, 0),
            ],
        ];

        foreach ($flights as $flightData) {
            Flight::updateOrCreate(
                ['flight_number' => $flightData['flight_number']],
                $flightData
            );
        }
    }
}
