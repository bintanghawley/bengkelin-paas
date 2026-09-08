<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = ServiceBooking::with(['user', 'service', 'mechanic'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = ServiceBooking::with(['user', 'service', 'mechanic'])->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = ServiceBooking::findOrFail($id);

        $validated = $request->validate([
            'action' => 'required|in:cancel',
        ]);

        abort_unless(in_array($booking->status, ['pending', 'diterima', 'diproses'], true), 422, 'Booking tidak dapat dibatalkan pada status ini.');

        DB::transaction(function () use ($validated, $booking) {
            if ($validated['action'] === 'cancel') {
                $booking->update([
                    'status' => 'dibatalkan',
                ]);
            }
        });

        return redirect()->route('admin.bookings.show', $booking->id)
            ->with('success', 'Booking berhasil dibatalkan.');
    }
}
