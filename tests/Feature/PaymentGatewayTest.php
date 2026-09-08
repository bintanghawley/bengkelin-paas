<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentGatewayTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $admin;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        // Create user roles
        $this->user = User::create([
            'name' => 'John Pengguna',
            'email' => 'pengguna@example.com',
            'password' => bcrypt('password'),
            'role' => 'pengguna',
            'nomor_telepon' => '081234567890',
        ]);

        $this->admin = User::create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'nomor_telepon' => '081234567891',
        ]);

        // Create product
        $this->product = Product::create([
            'nama' => 'Ban Motor Tubeless',
            'harga' => 150000,
            'stok' => 10,
            'deskripsi' => 'Ban berkualitas tinggi.',
            'jenis_ban' => 'tubeless',
            'merek' => 'IRC',
            'ukuran_ban' => '90/80-14',
            'posisi_ban' => 'belakang',
            'material' => 'medium compound',
            'diameter' => '14',
            'tipe' => 'sport',
            'kategori' => 'ban',
        ]);
    }

    /**
     * Test checkout with Transfer Bank redirects to Payment Gateway.
     */
    public function test_checkout_transfer_bank_redirects_to_payment_gateway(): void
    {
        $response = $this->actingAs($this->user)->post(route('toko.buy', $this->product->id), [
            'jumlah' => 2,
            'alamat' => 'Jl. Raya Surabaya No. 12',
            'telepon' => '081234567890',
            'metode_pembayaran' => 'Transfer Bank',
            'catatan' => 'Kirim cepat ya',
        ]);

        $purchase = Purchase::first();
        $this->assertNotNull($purchase);
        $this->assertEquals('menunggu_pembayaran', $purchase->status);

        $payment = Payment::first();
        $this->assertNotNull($payment);
        $this->assertEquals(300000, $payment->amount);
        $this->assertEquals('pending', $payment->status);
        $this->assertEquals($payment->id, $purchase->payment_id);

        $response->assertRedirect(route('pengguna.payments.show', $payment->id));
    }

    /**
     * Test checkout with COD bypasses Payment Gateway.
     */
    public function test_checkout_cod_bypasses_payment_gateway(): void
    {
        $response = $this->actingAs($this->user)->post(route('toko.buy', $this->product->id), [
            'jumlah' => 1,
            'alamat' => 'Jl. Raya Surabaya No. 12',
            'telepon' => '081234567890',
            'metode_pembayaran' => 'COD',
            'catatan' => 'Bayar di tempat',
        ]);

        $purchase = Purchase::first();
        $this->assertNotNull($purchase);
        $this->assertEquals('diproses', $purchase->status);

        // No payment record should be created
        $this->assertEquals(0, Payment::count());

        $response->assertRedirect(route('toko.result', $purchase->id));
    }

    /**
     * Test selecting payment method updates details.
     */
    public function test_user_can_select_payment_method(): void
    {
        // Setup a pending payment
        $payment = Payment::create([
            'invoice_number' => Payment::generateInvoice(),
            'amount' => 150000,
            'status' => 'pending',
            'expired_at' => now()->addHour(),
        ]);

        $purchase = Purchase::create([
            'user_id' => $this->user->id,
            'barang_id' => $this->product->id,
            'barang_nama' => $this->product->nama,
            'harga' => 150000,
            'jumlah' => 1,
            'total_harga' => 150000,
            'alamat' => 'Jl. Surabaya',
            'telepon' => '081234567890',
            'metode_pembayaran' => 'Transfer Bank',
            'status' => 'menunggu_pembayaran',
            'payment_id' => $payment->id,
        ]);

        $response = $this->actingAs($this->user)->post(route('pengguna.payments.select-method', $payment->id), [
            'payment_method' => 'BCA Virtual Account',
        ]);

        $payment->refresh();
        $this->assertEquals('BCA Virtual Account', $payment->payment_method);
        $this->assertNotNull($payment->payment_code);
        $this->assertStringStartsWith('88', $payment->payment_code);

        $response->assertRedirect();
    }

    /**
     * Test local simulation payment success.
     */
    public function test_user_can_simulate_payment_success(): void
    {
        $payment = Payment::create([
            'invoice_number' => Payment::generateInvoice(),
            'amount' => 150000,
            'status' => 'pending',
            'expired_at' => now()->addHour(),
        ]);

        $purchase = Purchase::create([
            'user_id' => $this->user->id,
            'barang_id' => $this->product->id,
            'barang_nama' => $this->product->nama,
            'harga' => 150000,
            'jumlah' => 1,
            'total_harga' => 150000,
            'alamat' => 'Jl. Surabaya',
            'telepon' => '081234567890',
            'metode_pembayaran' => 'Transfer Bank',
            'status' => 'menunggu_pembayaran',
            'payment_id' => $payment->id,
        ]);

        $response = $this->actingAs($this->user)->post(route('pengguna.payments.pay', $payment->id));

        $payment->refresh();
        $purchase->refresh();

        $this->assertEquals('paid', $payment->status);
        $this->assertNotNull($payment->paid_at);
        $this->assertEquals('diproses', $purchase->status);

        $response->assertRedirect(route('pengguna.payments.success', $payment->id));
    }

    /**
     * Test checking expired payment.
     */
    public function test_expired_payment_marked_correctly_on_access(): void
    {
        $payment = Payment::create([
            'invoice_number' => Payment::generateInvoice(),
            'amount' => 150000,
            'status' => 'pending',
            'expired_at' => now()->subMinutes(10), // expired 10 minutes ago
        ]);

        $purchase = Purchase::create([
            'user_id' => $this->user->id,
            'barang_id' => $this->product->id,
            'barang_nama' => $this->product->nama,
            'harga' => 150000,
            'jumlah' => 1,
            'total_harga' => 150000,
            'alamat' => 'Jl. Surabaya',
            'telepon' => '081234567890',
            'metode_pembayaran' => 'Transfer Bank',
            'status' => 'menunggu_pembayaran',
            'payment_id' => $payment->id,
        ]);

        $response = $this->actingAs($this->user)->get(route('pengguna.payments.show', $payment->id));

        $payment->refresh();
        $purchase->refresh();

        $this->assertEquals('expired', $payment->status);
        $this->assertEquals('dibatalkan', $purchase->status);

        $response->assertRedirect(route('pengguna.payments.expired', $payment->id));
    }
}
