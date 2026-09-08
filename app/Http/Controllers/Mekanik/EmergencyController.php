<?php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\EmergencyReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmergencyController extends Controller
{
    public function index()
    {
        $pendingEmergencies = EmergencyReport::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        $myEmergencies = EmergencyReport::with('user')
            ->where('mechanic_id', Auth::id())
            ->whereIn('status', ['diterima', 'dalam_perjalanan', 'sampai_lokasi', 'selesai', 'ditolak'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('mekanik.emergency.index', compact('pendingEmergencies', 'myEmergencies'));
    }

    public function show($id)
    {
        $emergency = EmergencyReport::with(['user', 'mechanic', 'assistanceRequests.targetMechanic'])
            ->where(function ($q) {
                $q->where('status', 'pending')
                    ->orWhere('mechanic_id', Auth::id());
            })
            ->findOrFail($id);

        $mechanics = User::where('role', 'mekanik')
            ->whereKeyNot(Auth::id())
            ->orderBy('name')
            ->get();

        return view('mekanik.emergency.show', compact('emergency', 'mechanics'));
    }

    public function update(Request $request, $id)
    {
        $emergency = EmergencyReport::where(function ($q) {
            $q->where('status', 'pending')
                ->orWhere('mechanic_id', Auth::id());
        })->findOrFail($id);

        $validated = $request->validate([
            'action' => 'required|in:accept,reject,travel,arrive,complete',
            'catatan_mekanik' => 'nullable|string|max:2000',
        ]);

        DB::transaction(function () use ($validated, $emergency) {
            $emergency = EmergencyReport::lockForUpdate()->findOrFail($emergency->id);

            switch ($validated['action']) {
                case 'accept':
                    if ($emergency->status !== 'pending') {
                        abort(422, 'Laporan tidak dalam status pending.');
                    }
                    $emergency->update([
                        'status' => 'diterima',
                        'mechanic_id' => Auth::id(),
                    ]);
                    break;

                case 'reject':
                    if ($emergency->status !== 'pending') {
                        abort(422, 'Laporan tidak dalam status pending.');
                    }
                    $emergency->update([
                        'status' => 'ditolak',
                        'mechanic_id' => Auth::id(),
                        'catatan_mekanik' => $validated['catatan_mekanik'],
                    ]);
                    break;

                case 'travel':
                    if ($emergency->status !== 'diterima' || $emergency->mechanic_id !== Auth::id()) {
                        abort(422, 'Aksi tidak diizinkan.');
                    }
                    $emergency->update(['status' => 'dalam_perjalanan']);
                    break;

                case 'arrive':
                    if ($emergency->status !== 'dalam_perjalanan' || $emergency->mechanic_id !== Auth::id()) {
                        abort(422, 'Aksi tidak diizinkan.');
                    }
                    $emergency->update(['status' => 'sampai_lokasi']);
                    break;

                case 'complete':
                    if (! in_array($emergency->status, ['dalam_perjalanan', 'sampai_lokasi']) || $emergency->mechanic_id !== Auth::id()) {
                        abort(422, 'Aksi tidak diizinkan.');
                    }
                    $emergency->update([
                        'status' => 'selesai',
                        'catatan_mekanik' => $validated['catatan_mekanik'],
                    ]);
                    break;
            }
        });

        $message = match ($validated['action']) {
            'accept' => 'Laporan darurat diterima! Siap menuju lokasi.',
            'reject' => 'Laporan darurat ditolak.',
            'travel' => 'Perjalanan ke lokasi dimulai.',
            'arrive' => 'Sampai di lokasi pelanggan.',
            'complete' => 'Penanganan darurat selesai.',
        };

        return redirect()->route('mekanik.emergency.index')
            ->with('success', $message);
    }
}
