<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    private function checkPengguna()
    {
        if (Auth::user()->role !== 'pengguna') {
            return redirect()->route('home')->with('error', 'Akses ditolak');
        }

        return null;
    }

    public function dashboard()
    {
        $check = $this->checkPengguna();
        if ($check) {
            return $check;
        }

        $user = Auth::user();
        $bookings = \App\Models\ServiceBooking::with(['service', 'mechanic'])
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();
        $services = Service::withCount('items')->orderBy('nama', 'asc')->get();
        $purchases = \App\Models\Purchase::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        return view('pengguna.dashboard', compact('user', 'bookings', 'services', 'purchases'));
    }
}

