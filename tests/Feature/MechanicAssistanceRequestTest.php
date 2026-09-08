<?php

namespace Tests\Feature;

use App\Models\EmergencyReport;
use App\Models\MechanicAssistanceRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MechanicAssistanceRequestTest extends TestCase
{
    use RefreshDatabase;

    private User $requester;

    private User $target;

    private User $otherMechanic;

    private User $customer;

    private EmergencyReport $emergency;

    protected function setUp(): void
    {
        parent::setUp();

        $this->requester = User::create(['name' => 'Teknisi Utama', 'nomor_telepon' => '081111111111', 'password' => bcrypt('password'), 'role' => 'mekanik']);
        $this->target = User::create(['name' => 'Teknisi Bantuan', 'nomor_telepon' => '082222222222', 'password' => bcrypt('password'), 'role' => 'mekanik']);
        $this->otherMechanic = User::create(['name' => 'Teknisi Lain', 'nomor_telepon' => '083333333333', 'password' => bcrypt('password'), 'role' => 'mekanik']);
        $this->customer = User::create(['name' => 'Pelanggan', 'nomor_telepon' => '084444444444', 'password' => bcrypt('password'), 'role' => 'pengguna']);

        $this->emergency = EmergencyReport::create([
            'user_id' => $this->customer->id,
            'mechanic_id' => $this->requester->id,
            'nama_kendaraan' => 'Honda Vario',
            'plat_nomor' => 'L 1234 AB',
            'keluhan' => 'Motor mogok di jalan',
            'latitude' => -7.4478,
            'longitude' => 112.7183,
            'lokasi_detail' => 'Depan SPBU Pagerwojo',
            'status' => 'dalam_perjalanan',
        ]);
    }

    public function test_complete_assistance_request_flow(): void
    {
        $this->actingAs($this->requester)
            ->post(route('mekanik.assistance-requests.store', $this->emergency), [
                'target_mechanic_id' => $this->target->id,
                'needed_item' => 'Kunci shock 24 mm',
                'reason' => 'Alat tertinggal di bengkel',
                'location_detail' => 'Depan SPBU Pagerwojo',
                'maps_url' => 'https://www.openstreetmap.org/search?query=Pagerwojo',
            ])->assertRedirect();

        $request = MechanicAssistanceRequest::firstOrFail();
        $this->assertSame('pending', $request->status);

        $this->actingAs($this->target)
            ->patch(route('mekanik.assistance-requests.accept', $request))
            ->assertRedirect();
        $this->assertSame('accepted', $request->fresh()->status);
        $this->assertNotNull($request->fresh()->responded_at);

        $this->actingAs($this->requester)
            ->patch(route('mekanik.assistance-requests.complete', $request))
            ->assertRedirect();
        $this->assertSame('completed', $request->fresh()->status);
        $this->assertNotNull($request->fresh()->completed_at);
    }

    public function test_only_assigned_mechanic_can_create_request(): void
    {
        $this->actingAs($this->otherMechanic)
            ->post(route('mekanik.assistance-requests.store', $this->emergency), $this->validPayload())
            ->assertForbidden();
    }

    public function test_customer_cannot_access_mechanic_routes(): void
    {
        $this->actingAs($this->customer)
            ->get(route('mekanik.assistance-requests.index'))
            ->assertForbidden();
    }

    public function test_only_target_can_accept_request(): void
    {
        $request = $this->createRequest();

        $this->actingAs($this->otherMechanic)
            ->patch(route('mekanik.assistance-requests.accept', $request))
            ->assertForbidden();
    }

    public function test_emergency_cannot_have_two_active_requests(): void
    {
        $this->createRequest();

        $this->actingAs($this->requester)
            ->post(route('mekanik.assistance-requests.store', $this->emergency), $this->validPayload())
            ->assertStatus(422);

        $this->assertSame(1, MechanicAssistanceRequest::count());
    }

    public function test_rejected_request_allows_a_new_request(): void
    {
        $request = $this->createRequest();

        $this->actingAs($this->target)
            ->patch(route('mekanik.assistance-requests.reject', $request), ['response_note' => 'Sedang menangani pelanggan lain'])
            ->assertRedirect();

        $this->actingAs($this->requester)
            ->post(route('mekanik.assistance-requests.store', $this->emergency), [
                ...$this->validPayload(),
                'target_mechanic_id' => $this->otherMechanic->id,
            ])->assertRedirect();

        $this->assertSame(2, MechanicAssistanceRequest::count());
    }

    private function createRequest(): MechanicAssistanceRequest
    {
        return MechanicAssistanceRequest::create([
            ...$this->validPayload(),
            'emergency_report_id' => $this->emergency->id,
            'requester_mechanic_id' => $this->requester->id,
            'status' => 'pending',
        ]);
    }

    private function validPayload(): array
    {
        return [
            'target_mechanic_id' => $this->target->id,
            'needed_item' => 'Kunci shock 24 mm',
            'reason' => 'Alat tertinggal',
            'location_detail' => 'Depan SPBU Pagerwojo',
            'maps_url' => 'https://www.openstreetmap.org/search?query=Pagerwojo',
        ];
    }
}
