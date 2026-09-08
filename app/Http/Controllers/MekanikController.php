<?php

namespace App\Http\Controllers;

use App\Models\EmergencyReport;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MekanikController extends Controller
{
    private function checkMekanik()
    {
        if (Auth::user()->role !== 'mekanik') {
            return redirect()->route('home')->with('error', 'Akses ditolak');
        }

        return null;
    }

    public function dashboard()
    {
        $check = $this->checkMekanik();
        if ($check) {
            return $check;
        }

        // Pending bookings - all mekaniks can see & accept
        $pendingCount = ServiceBooking::where('status', 'pending')->count();

        // Pending emergency reports
        $pendingEmergencyCount = EmergencyReport::where('status', 'pending')->count();

        // My active bookings (diterima/diproses)
        $activeBookings = ServiceBooking::with(['user', 'service'])
            ->where('mechanic_id', Auth::id())
            ->whereIn('status', ['diterima', 'diproses'])
            ->orderBy('tanggal_booking', 'asc')
            ->get();

        // My completed bookings
        $completedCount = ServiceBooking::where('mechanic_id', Auth::id())
            ->where('status', 'selesai')
            ->count();

        // All my bookings for the table
        $bookings = ServiceBooking::with(['user', 'service'])
            ->where('mechanic_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('mekanik.dashboard', compact(
            'bookings',
            'pendingCount',
            'pendingEmergencyCount',
            'activeBookings',
            'completedCount'
        ));
    }
}
