<?php

namespace Tests\Feature;

use App\Models\Purchase;
use App\Models\Tire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TireTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private User $admin;

    private Tire $tire;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Tire Customer',
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

        $this->tire = Tire::create([
            'nama' => 'Michelin Pilot Street',
            'harga' => 350000,
            'stok' => 10,
            'jenis_ban' => 'ban motor sport',
            'merek' => 'Michelin',
            'ukuran_ban' => '110/70',
            'posisi_ban' => 'depan',
            'material' => 'medium compound',
            'diameter' => 'Ring 17',
            'tipe' => 'tubeless',
            'fitur' => 'Tread pattern designed for grip, Long lasting compound',
            'deskripsi' => 'Ban harian dengan performa andalan Michelin',
        ]);
    }

    public function test_catalog_page_loads_and_displays_tires(): void
    {
        $response = $this->get(route('toko.banmotor'));

        $response->assertStatus(200);
        $response->assertSee('Michelin Pilot Street');
    }

    public function test_detail_page_loads_and_displays_tire_specs(): void
    {
        $response = $this->get(route('toko.banmotor.show', $this->tire->id));

        $response->assertStatus(200);
        $response->assertSee('Michelin Pilot Street');
        $response->assertSee('110/70');
        $response->assertSee('Ring 17');
    }

    public function test_authenticated_user_can_access_checkout_and_buy_tire(): void
    {
        // 1. Checkout view
        $response = $this->actingAs($this->user)
            ->get(route('toko.banmotor.checkout', $this->tire->id));
        $response->assertStatus(200);

        // 2. Post Buy request
        $response = $this->actingAs($this->user)
            ->post(route('toko.banmotor.buy', $this->tire->id), [
                'jumlah' => 2,
                'alamat' => 'Jl. Motor Raya No. 45, Jakarta',
                'telepon' => '081234567892',
                'metode_pembayaran' => 'COD',
                'catatan' => 'Kirim sore hari ya',
            ]);

        // Purchase model redirects to result page (e.g. toko.result route)
        $purchase = Purchase::first();
        $this->assertNotNull($purchase);

        $response->assertRedirect(route('toko.result', $purchase->id));

        // Assert stock decrement
        $this->assertEquals(8, $this->tire->fresh()->stok);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $this->user->id,
            'barang_id' => $this->tire->id,
            'barang_nama' => 'Michelin Pilot Street',
            'jumlah' => 2,
            'total_harga' => 700000,
            'alamat' => 'Jl. Motor Raya No. 45, Jakarta',
            'status' => 'diproses',
        ]);
    }

    public function test_admin_can_crud_tires(): void
    {
        // 1. Create a tire (store)
        $response = $this->actingAs($this->admin)
            ->post('/admin/tires', [
                'nama' => 'Aspira Premio',
                'harga' => 250000,
                'stok' => 15,
                'jenis_ban' => 'ban motor matic',
                'merek' => 'aspira',
                'ukuran_ban' => '90/90',
                'posisi_ban' => 'belakang',
                'material' => 'medium compound',
                'diameter' => 'Ring 14',
                'tipe' => 'tubeless',
            ]);

        $response->assertStatus(302); // redirect back
        $this->assertDatabaseHas('tires', [
            'nama' => 'Aspira Premio',
            'merek' => 'aspira',
            'stok' => 15,
        ]);

        $newTire = Tire::where('nama', 'Aspira Premio')->first();

        // 2. Update a tire (update)
        $response = $this->actingAs($this->admin)
            ->put('/admin/tires/'.$newTire->id, [
                'nama' => 'Aspira Premio Sporty',
                'harga' => 260000,
                'stok' => 20,
                'jenis_ban' => 'ban motor matic',
                'merek' => 'aspira',
                'ukuran_ban' => '90/90',
                'posisi_ban' => 'belakang',
                'material' => 'medium compound',
                'diameter' => 'Ring 14',
                'tipe' => 'tubeless',
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('tires', [
            'id' => $newTire->id,
            'nama' => 'Aspira Premio Sporty',
            'harga' => 260000,
            'stok' => 20,
        ]);

        // 3. Delete a tire (destroy)
        $response = $this->actingAs($this->admin)
            ->delete('/admin/tires/'.$newTire->id);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('tires', [
            'id' => $newTire->id,
        ]);
    }

    public function test_guest_or_regular_user_cannot_crud_tires(): void
    {
        // Guests cannot store
        $response = $this->post('/admin/tires', [
            'nama' => 'Pirelli Diablo Rosso',
        ]);
        $response->assertStatus(302); // Redirect to login or home

        // Regular user cannot store
        $response = $this->actingAs($this->user)
            ->post('/admin/tires', [
                'nama' => 'Pirelli Diablo Rosso',
            ]);
        $response->assertForbidden();
    }
}
