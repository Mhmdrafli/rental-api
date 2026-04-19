<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        return response()->json(Car::all());
    }

    public function show($id)
    {
        $car = Car::find($id);
        if (!$car) {
            return response()->json(['message' => 'Mobil tidak ditemukan'], 404);
        }
        return response()->json($car);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string',
            'type'              => 'required|in:manual,electric',
            'image_url'         => 'nullable|string',
            'daily_price'       => 'required|integer|min:0',
            'fine_pct_per_hour' => 'required|integer|min:0',
            'seats'             => 'required|integer|min:1',
            'status'            => 'required|in:ready,rented,maintenance',
        ]);

        $car = Car::create($data);
        return response()->json($car, 201);
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);
        $data = $request->validate([
            'name'              => 'sometimes|string',
            'type'              => 'sometimes|in:manual,electric',
            'image_url'         => 'nullable|string',
            'daily_price'       => 'sometimes|integer|min:0',
            'fine_pct_per_hour' => 'sometimes|integer|min:0',
            'seats'             => 'sometimes|integer|min:1',
            'status'            => 'sometimes|in:ready,rented,maintenance',
        ]);

        $car->update($data);
        return response()->json($car);
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();
        return response()->json(['ok' => true]);
    }
}