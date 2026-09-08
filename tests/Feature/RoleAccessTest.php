<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $mechanic;

    private User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create(['name' => 'Admin', 'nomor_telepon' => '081111111111', 'password' => bcrypt('password'), 'role' => 'admin']);
        $this->mechanic = User::create(['name' => 'Mechanic', 'nomor_telepon' => '082222222222', 'password' => bcrypt('password'), 'role' => 'mekanik']);
        $this->customer = User::create(['name' => 'Customer', 'nomor_telepon' => '083333333333', 'password' => bcrypt('password'), 'role' => 'pengguna']);
    }

    public function test_role_dashboards_are_protected(): void
    {
        $this->actingAs($this->customer)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($this->customer)->get(route('mekanik.dashboard'))->assertForbidden();
        $this->actingAs($this->mechanic)->get(route('pengguna.dashboard'))->assertForbidden();
        $this->actingAs($this->admin)->get(route('pengguna.dashboard'))->assertForbidden();
    }

    public function test_only_customer_can_create_booking(): void
    {
        $service = Service::create([
            'nama' => 'Servis Ringan',
            'slug' => 'servis-ringan',
            'deskripsi' => 'Perawatan rutin',
            'harga_mulai' => 75000,
            'estimasi_waktu' => '30 Menit',
        ]);

        $this->actingAs($this->mechanic)->get(route('booking.create', $service->slug))->assertForbidden();
        $this->actingAs($this->customer)->get(route('booking.create', $service->slug))->assertOk();
    }

    public function test_only_customer_can_access_cart_checkout(): void
    {
        $this->actingAs($this->mechanic)->get(route('cart.checkout'))->assertForbidden();
        $this->actingAs($this->customer)->get(route('cart.checkout'))->assertOk();
    }

    public function test_other_customer_cannot_access_payment_actions(): void
    {
        $otherCustomer = User::create(['name' => 'Other', 'nomor_telepon' => '084444444444', 'password' => bcrypt('password'), 'role' => 'pengguna']);
        $payment = Payment::create([
            'invoice_number' => Payment::generateInvoice(),
            'amount' => 100000,
            'status' => 'pending',
            'expired_at' => now()->addHour(),
        ]);
        Purchase::create([
            'user_id' => $this->customer->id,
            'barang_id' => 1,
            'barang_nama' => 'Produk',
            'harga' => 100000,
            'jumlah' => 1,
            'total_harga' => 100000,
            'metode_pembayaran' => 'Transfer Bank',
            'status' => 'menunggu_pembayaran',
            'payment_id' => $payment->id,
        ]);

        $this->actingAs($otherCustomer)
            ->post(route('pengguna.payments.select-method', $payment), ['payment_method' => 'QRIS'])
            ->assertForbidden();
        $this->actingAs($otherCustomer)->post(route('pengguna.payments.pay', $payment))->assertForbidden();
        $this->actingAs($otherCustomer)->get(route('pengguna.payments.success', $payment))->assertForbidden();
    }

    public function test_admin_can_access_admin_features(): void
    {
        $this->actingAs($this->admin)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.bookings.index'))->assertOk();
    }
}
