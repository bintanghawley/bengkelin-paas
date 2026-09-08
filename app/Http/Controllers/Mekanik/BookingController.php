<?php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Show all bookings visible to mekanik:
     *  - pending bookings (any mekanik can accept/reject)
     *  - bookings accepted/in-progress by THIS mekanik
     */
    public function index()
    {
        // Pending bookings (available to accept)
        $pendingBookings = ServiceBooking::with(['user', 'service'])
            ->where('status', 'pending')
            ->orderBy('tanggal_booking', 'asc')
            ->get();

        // My accepted/in-progress bookings
        $myBookings = ServiceBooking::with(['user', 'service'])
            ->where('mechanic_id', Auth::id())
            ->whereIn('status', ['diterima', 'diproses', 'selesai', 'ditolak'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('mekanik.bookings.index', compact('pendingBookings', 'myBookings'));
    }

    /**
     * Show a single booking detail.
     * Mekanik can view pending bookings (to accept/reject) or their own bookings.
     */
    public function show($id)
    {
        $booking = ServiceBooking::with(['user', 'service', 'mechanic'])
            ->where(function ($q) {
                $q->where('status', 'pending')
                    ->orWhere('mechanic_id', Auth::id());
            })
            ->findOrFail($id);

        return view('mekanik.bookings.show', compact('booking'));
    }

    /**
     * Update booking status.
     * Actions: accept (pending→diterima), reject (pending→ditolak),
     *          start (diterima→diproses), complete (diproses→selesai)
     */
    public function update(Request $request, $id)
    {
        $booking = ServiceBooking::where(function ($q) {
            $q->where('status', 'pending')
                ->orWhere('mechanic_id', Auth::id());
        })->findOrFail($id);

        $validated = $request->validate([
            'action' => 'required|in:accept,reject,start,complete',
            'catatan_mekanik' => 'nullable|string|max:2000',
        ]);

        DB::transaction(function () use ($validated, $booking) {
            $booking = ServiceBooking::lockForUpdate()->findOrFail($booking->id);

            switch ($validated['action']) {
                case 'accept':
                    // Any mekanik can accept a pending booking
                    if ($booking->status !== 'pending') {
                        abort(422, 'Booking tidak dalam status pending.');
                    }
                    $booking->update([
                        'status' => 'diterima',
                        'mechanic_id' => Auth::id(),
                    ]);
                    break;

                case 'reject':
                    // Any mekanik can reject a pending booking
                    if ($booking->status !== 'pending') {
                        abort(422, 'Booking tidak dalam status pending.');
                    }
                    $booking->update([
                        'status' => 'ditolak',
                        'mechanic_id' => Auth::id(),
                        'catatan_mekanik' => $validated['catatan_mekanik'],
                    ]);
                    break;

                case 'start':
                    // Only assigned mekanik can start
                    if ($booking->status !== 'diterima' || $booking->mechanic_id !== Auth::id()) {
                        abort(422, 'Aksi tidak diizinkan.');
                    }
                    $booking->update(['status' => 'diproses']);
                    break;

                case 'complete':
                    // Only assigned mekanik can complete
                    if ($booking->status !== 'diproses' || $booking->mechanic_id !== Auth::id()) {
                        abort(422, 'Aksi tidak diizinkan.');
                    }
                    $booking->update([
                        'status' => 'selesai',
                        'catatan_mekanik' => $validated['catatan_mekanik'],
                    ]);
                    break;
            }
        });

        $message = match ($validated['action']) {
            'accept' => 'Booking berhasil diterima! Silakan mulai pengerjaan.',
            'reject' => 'Booking telah ditolak.',
            'start' => 'Pengerjaan servis dimulai.',
            'complete' => 'Servis telah diselesaikan.',
        };

        return redirect()->route('mekanik.bookings.index')
            ->with('success', $message);
    }
}
