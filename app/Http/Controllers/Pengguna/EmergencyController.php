<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\EmergencyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmergencyController extends Controller
{
    public function index()
    {
        $emergencies = Auth::user()->emergencyReports()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pengguna.emergency.index', compact('emergencies'));
    }

    public function create()
    {
        return view('pengguna.emergency.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:20',
            'keluhan' => 'required|string|max:2000',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'lokasi_detail' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($validated) {
            EmergencyReport::create([
                'user_id' => Auth::id(),
                'nama_kendaraan' => $validated['nama_kendaraan'],
                'plat_nomor' => $validated['plat_nomor'],
                'keluhan' => $validated['keluhan'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'lokasi_detail' => $validated['lokasi_detail'] ?? null,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('pengguna.emergency.index')
            ->with('success', 'Laporan darurat berhasil dikirim! Mekanik segera menuju lokasi Anda.');
    }

    public function show($id)
    {
        $emergency = EmergencyReport::where('user_id', Auth::id())->findOrFail($id);

        return view('pengguna.emergency.show', compact('emergency'));
    }
}
