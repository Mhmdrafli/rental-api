<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'method'     => 'required|in:transfer,qris',
            'amount'     => 'required|numeric|min:0',
            'proof'      => 'nullable|image|max:5120',
        ]);

        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('proofs', 'public');
        }

        $payment = Payment::create([
            'booking_id' => $request->booking_id,
            'method'     => $request->method,
            'amount'     => $request->amount,
            'proof_url'  => $proofPath ? asset('storage/' . $proofPath) : null,
            'status'     => 'pending',
        ]);

        return response()->json($payment, 201);
    }

    public function approve($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'approved']);
        $payment->booking->update(['status' => 'active']);

        return response()->json(['ok' => true]);
    }

    public function reject($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'rejected']);
        $payment->booking->update(['status' => 'awaiting_payment']);

        return response()->json(['ok' => true]);
    }
}