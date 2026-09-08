<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->serviceBookings()
            ->with('service')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pengguna.bookings.index', compact('bookings'));
    }

    public function create($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();

        return view('pengguna.bookings.create', compact('service'));
    }

    public function store(Request $request, $slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:20',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_booking' => ['required', 'date_format:H:i'],
            'keluhan' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($validated, $service) {
            ServiceBooking::create([
                'user_id' => Auth::id(),
                'service_id' => $service->id,
                'nama_kendaraan' => $validated['nama_kendaraan'],
                'plat_nomor' => $validated['plat_nomor'],
                'tanggal_booking' => $validated['tanggal_booking'],
                'jam_booking' => $validated['jam_booking'],
                'keluhan' => $validated['keluhan'],
                'status' => 'pending',
            ]);
        });

        return redirect()->route('pengguna.dashboard', ['section' => 'status'])
            ->with('success', 'Booking servis berhasil diajukan.');
    }

    public function show($id)
    {
        $booking = ServiceBooking::with(['service', 'mechanic'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pengguna.bookings.show', compact('booking'));
    }
}
