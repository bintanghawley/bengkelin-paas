<?php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\EmergencyReport;
use App\Models\MechanicAssistanceRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AssistanceRequestController extends Controller
{
    public function index(Request $request): View
    {
        $incoming = MechanicAssistanceRequest::with(['emergencyReport.user', 'requesterMechanic'])
            ->where('target_mechanic_id', $request->user()->id)
            ->latest()
            ->get();

        $outgoing = MechanicAssistanceRequest::with(['emergencyReport.user', 'targetMechanic'])
            ->where('requester_mechanic_id', $request->user()->id)
            ->latest()
            ->get();

        return view('mekanik.assistance-requests.index', compact('incoming', 'outgoing'));
    }

    public function store(Request $request, EmergencyReport $emergency): RedirectResponse
    {
        abort_unless(
            $emergency->mechanic_id === $request->user()->id
            && in_array($emergency->status, ['diterima', 'dalam_perjalanan', 'sampai_lokasi'], true),
            403,
        );

        $validated = $request->validate([
            'target_mechanic_id' => ['required', 'integer', 'exists:users,id', 'different:requester_mechanic_id'],
            'needed_item' => ['required', 'string', 'max:255'],
            'reason' => ['nullable', 'string', 'max:2000'],
            'location_detail' => ['required', 'string', 'max:500'],
            'maps_url' => ['nullable', 'url', 'max:1000'],
        ]);

        $target = User::whereKey($validated['target_mechanic_id'])
            ->where('role', 'mekanik')
            ->firstOrFail();

        abort_if($target->is($request->user()), 422, 'Anda tidak dapat meminta bantuan kepada diri sendiri.');

        DB::transaction(function () use ($emergency, $request, $validated, $target): void {
            $lockedEmergency = EmergencyReport::lockForUpdate()->findOrFail($emergency->id);
            abort_unless(
                $lockedEmergency->mechanic_id === $request->user()->id
                && in_array($lockedEmergency->status, ['diterima', 'dalam_perjalanan', 'sampai_lokasi'], true),
                403,
            );

            $hasActiveRequest = MechanicAssistanceRequest::where('emergency_report_id', $lockedEmergency->id)
                ->whereIn('status', ['pending', 'accepted'])
                ->exists();
            abort_if($hasActiveRequest, 422, 'Laporan darurat ini masih memiliki permintaan bantuan aktif.');

            MechanicAssistanceRequest::create([
                ...$validated,
                'emergency_report_id' => $lockedEmergency->id,
                'requester_mechanic_id' => $request->user()->id,
                'target_mechanic_id' => $target->id,
                'status' => 'pending',
            ]);
        });

        return back()->with('success', 'Permintaan bantuan berhasil dikirim.');
    }

    public function show(Request $request, MechanicAssistanceRequest $assistanceRequest): View
    {
        $this->authorizeParticipant($request, $assistanceRequest);
        $assistanceRequest->load(['emergencyReport.user', 'requesterMechanic', 'targetMechanic']);

        return view('mekanik.assistance-requests.show', compact('assistanceRequest'));
    }

    public function accept(Request $request, MechanicAssistanceRequest $assistanceRequest): RedirectResponse
    {
        $this->respond($request, $assistanceRequest, 'accepted');

        return back()->with('success', 'Permintaan bantuan diterima.');
    }

    public function reject(Request $request, MechanicAssistanceRequest $assistanceRequest): RedirectResponse
    {
        $validated = $request->validate(['response_note' => ['nullable', 'string', 'max:2000']]);
        $this->respond($request, $assistanceRequest, 'rejected', $validated['response_note'] ?? null);

        return back()->with('success', 'Permintaan bantuan ditolak.');
    }

    public function cancel(Request $request, MechanicAssistanceRequest $assistanceRequest): RedirectResponse
    {
        abort_unless($assistanceRequest->requester_mechanic_id === $request->user()->id, 403);
        abort_unless($assistanceRequest->isPending(), 422, 'Permintaan ini tidak dapat dibatalkan.');

        $assistanceRequest->update(['status' => 'cancelled']);

        return back()->with('success', 'Permintaan bantuan dibatalkan.');
    }

    public function complete(Request $request, MechanicAssistanceRequest $assistanceRequest): RedirectResponse
    {
        abort_unless($assistanceRequest->requester_mechanic_id === $request->user()->id, 403);
        abort_unless($assistanceRequest->isAccepted(), 422, 'Bantuan belum diterima.');

        $assistanceRequest->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Bantuan teknisi telah diselesaikan.');
    }

    private function respond(Request $request, MechanicAssistanceRequest $assistanceRequest, string $status, ?string $note = null): void
    {
        abort_unless($assistanceRequest->target_mechanic_id === $request->user()->id, 403);

        DB::transaction(function () use ($assistanceRequest, $status, $note): void {
            $lockedRequest = MechanicAssistanceRequest::lockForUpdate()->findOrFail($assistanceRequest->id);
            abort_unless($lockedRequest->isPending(), 422, 'Permintaan ini sudah direspons.');
            $lockedRequest->update([
                'status' => $status,
                'response_note' => $note,
                'responded_at' => now(),
            ]);
        });
    }

    private function authorizeParticipant(Request $request, MechanicAssistanceRequest $assistanceRequest): void
    {
        abort_unless(in_array($request->user()->id, [
            $assistanceRequest->requester_mechanic_id,
            $assistanceRequest->target_mechanic_id,
        ], true), 403);
    }
}
