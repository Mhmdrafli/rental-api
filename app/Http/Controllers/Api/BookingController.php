<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['car', 'payment']);  // ← tambah 'payment'

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json($query->latest()->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'car_id'   => 'required|exists:cars,id',
            'user_id'  => 'required',
            'start_at' => 'required|date',
            'end_at'   => 'required|date|after:start_at',
        ]);

        $car = Car::findOrFail($data['car_id']);
        $days = max(1, ceil((strtotime($data['end_at']) - strtotime($data['start_at'])) / 86400));

        $data['base_total']  = $car->daily_price * $days;
        $data['fine_amount'] = 0;
        $data['status']      = 'awaiting_payment';
        $data['user_id']     = (int) $data['user_id'];  // ← cast ke integer

        $car->update(['status' => 'rented']);

        $booking = Booking::create($data);

        return response()->json($booking->load(['car', 'payment']), 201);
    }

    public function show($id)
    {
        return response()->json(Booking::with(['car', 'payment'])->findOrFail($id));
    }

    public function returnCar(Request $request, $id)
    {
        $request->validate(['returned_at' => 'required|date']);

        $booking = Booking::with('car')->findOrFail($id);

        // Hitung denda
        $lateSeconds = max(0, strtotime($request->returned_at) - strtotime($booking->end_at));
        $lateHours   = ceil($lateSeconds / 3600);
        $fine        = $lateHours * ($booking->car->daily_price * ($booking->car->fine_pct_per_hour / 100));

        $booking->update([
            'returned_at' => $request->returned_at,
            'status'      => 'returned',
            'fine_amount' => round($fine),
        ]);

        // Bebaskan mobil
        $booking->car->update(['status' => 'ready']);

        return response()->json($booking->fresh('car'));
    }
}