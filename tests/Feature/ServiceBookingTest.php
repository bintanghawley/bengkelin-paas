<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\ServiceBooking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ServiceBookingTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private User $admin;

    private User $mechanic;

    private Service $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Roles / Users
        $this->user = User::create([
            'name' => 'John Doe',
            'nomor_telepon' => '081234567892',
            'password' => Hash::make('123456'),
            'role' => 'pengguna',
        ]);

        $this->admin = User::create([
            'name' => 'Admin Boss',
            'nomor_telepon' => '081234567890',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        $this->mechanic = User::create([
            'name' => 'Mechanic Pro',
            'nomor_telepon' => '081234567891',
            'password' => Hash::make('123456'),
            'role' => 'mekanik',
        ]);

        // Create a Service
        $this->service = Service::create([
            'nama' => 'Servis Ringan',
            'slug' => 'servis-ringan',
            'deskripsi' => 'Perawatan rutin',
            'harga_mulai' => 75000,
            'estimasi_waktu' => '30-60 Menit',
        ]);
    }

    public function test_user_can_book_service(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('booking.store', $this->service->slug), [
                'nama_kendaraan' => 'Honda Vario',
                'plat_nomor' => 'L 1234 XY',
                'tanggal_booking' => now()->addDay()->format('Y-m-d'),
                'jam_booking' => '10:00',
                'keluhan' => 'Ganti oli',
            ]);

        $response->assertRedirect(route('pengguna.dashboard', ['section' => 'status']));
        $this->assertDatabaseHas('service_bookings', [
            'user_id' => $this->user->id,
            'service_id' => $this->service->id,
            'nama_kendaraan' => 'Honda Vario',
            'status' => 'pending',
        ]);
    }

    public function test_admin_can_cancel_booking(): void
    {
        $booking = ServiceBooking::create([
            'user_id' => $this->user->id,
            'service_id' => $this->service->id,
            'nama_kendaraan' => 'Honda Vario',
            'plat_nomor' => 'L 1234 XY',
            'tanggal_booking' => now()->addDay()->format('Y-m-d'),
            'jam_booking' => '10:00',
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin)
            ->put(route('admin.bookings.update', $booking->id), ['action' => 'cancel'])
            ->assertRedirect(route('admin.bookings.show', $booking));

        $this->assertDatabaseHas('service_bookings', [
            'id' => $booking->id,
            'status' => 'dibatalkan',
        ]);
    }

    public function test_mechanic_can_process_and_complete_booking(): void
    {
        // Setup booking as accepted
        $booking = ServiceBooking::create([
            'user_id' => $this->user->id,
            'service_id' => $this->service->id,
            'nama_kendaraan' => 'Honda Vario',
            'plat_nomor' => 'L 1234 XY',
            'tanggal_booking' => now()->addDay()->format('Y-m-d'),
            'jam_booking' => '10:00',
            'mechanic_id' => $this->mechanic->id,
            'status' => 'diterima',
        ]);

        // 1. Start Job
        $response = $this->actingAs($this->mechanic)
            ->put(route('mekanik.bookings.update', $booking->id), [
                'action' => 'start',
            ]);

        $response->assertRedirect(route('mekanik.bookings.index'));
        $this->assertDatabaseHas('service_bookings', [
            'id' => $booking->id,
            'status' => 'diproses',
        ]);

        // 2. Complete Job
        $response = $this->actingAs($this->mechanic)
            ->put(route('mekanik.bookings.update', $booking->id), [
                'action' => 'complete',
                'catatan_mekanik' => 'Oli replaced, rear brakes adjusted',
            ]);

        $response->assertRedirect(route('mekanik.bookings.index'));
        $this->assertDatabaseHas('service_bookings', [
            'id' => $booking->id,
            'status' => 'selesai',
            'catatan_mekanik' => 'Oli replaced, rear brakes adjusted',
        ]);
    }
}
