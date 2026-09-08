<?php

namespace Tests\Feature;

use App\Models\Oil;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class OilTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private User $admin;

    private Oil $oil;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Oil Customer',
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

        $this->oil = Oil::create([
            'nama' => 'Motul GP Matic 4T 10W40 1 L',
            'harga' => 85000,
            'stok' => 15,
            'jenis_oli' => 'oli motor matic',
            'kekentalan' => '10W40',
            'ukuran' => '1 L',
            'tipe_oli' => 'Oli Ester',
            'merek' => 'Motul',
            'fitur' => 'Teknologi Ester, Proteksi tinggi terhadap oksidasi',
            'deskripsi' => 'Oli matic premium dengan basis Ester.',
        ]);
    }

    public function test_catalog_page_loads_and_displays_oils(): void
    {
        $response = $this->get(route('toko.oli'));

        $response->assertStatus(200);
        $response->assertSee('Motul GP Matic');
    }

    public function test_detail_page_loads_and_displays_oil_specs(): void
    {
        $response = $this->get(route('toko.oli.show', $this->oil->id));

        $response->assertStatus(200);
        $response->assertSee('Motul GP Matic');
        $response->assertSee('10W40');
        $response->assertSee('Oli Ester');
    }

    public function test_authenticated_user_can_access_checkout_and_buy_oil(): void
    {
        // 1. Checkout view
        $response = $this->actingAs($this->user)
            ->get(route('toko.oli.checkout', $this->oil->id));
        $response->assertStatus(200);

        // 2. Post Buy request
        $response = $this->actingAs($this->user)
            ->post(route('toko.oli.buy', $this->oil->id), [
                'jumlah' => 3,
                'alamat' => 'Jl. Oli Raya No. 12, Bandung',
                'telepon' => '081234567892',
                'metode_pembayaran' => 'COD',
                'catatan' => 'Kirim cepat ya',
            ]);

        $purchase = Purchase::first();
        $this->assertNotNull($purchase);

        $response->assertRedirect(route('toko.result', $purchase->id));

        // Assert stock decrement
        $this->assertEquals(12, $this->oil->fresh()->stok);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $this->user->id,
            'barang_id' => $this->oil->id,
            'barang_nama' => 'Motul GP Matic 4T 10W40 1 L',
            'jumlah' => 3,
            'total_harga' => 255000,
            'alamat' => 'Jl. Oli Raya No. 12, Bandung',
            'status' => 'diproses',
        ]);
    }

    public function test_admin_can_crud_oils(): void
    {
        // 1. Create oil (store)
        $response = $this->actingAs($this->admin)
            ->post('/admin/oils', [
                'nama' => 'Yamalube Power Matic 10W40 800 ml',
                'harga' => 52000,
                'stok' => 20,
                'jenis_oli' => 'oli motor matic',
                'kekentalan' => '10W40',
                'ukuran' => '800 ml',
                'tipe_oli' => 'Oli Semi Sintetik',
                'merek' => 'Yamalube',
            ]);

        $response->assertStatus(302); // redirect back
        $this->assertDatabaseHas('oils', [
            'nama' => 'Yamalube Power Matic 10W40 800 ml',
            'merek' => 'Yamalube',
            'stok' => 20,
        ]);

        $newOil = Oil::where('nama', 'Yamalube Power Matic 10W40 800 ml')->first();

        // 2. Update oil (update)
        $response = $this->actingAs($this->admin)
            ->put('/admin/oils/'.$newOil->id, [
                'nama' => 'Yamalube Power Matic Gold',
                'harga' => 55000,
                'stok' => 25,
                'jenis_oli' => 'oli motor matic',
                'kekentalan' => '10W40',
                'ukuran' => '800 ml',
                'tipe_oli' => 'Oli Semi Sintetik',
                'merek' => 'Yamalube',
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('oils', [
            'id' => $newOil->id,
            'nama' => 'Yamalube Power Matic Gold',
            'harga' => 55000,
            'stok' => 25,
        ]);

        // 3. Delete oil (destroy)
        $response = $this->actingAs($this->admin)
            ->delete('/admin/oils/'.$newOil->id);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('oils', [
            'id' => $newOil->id,
        ]);
    }

    public function test_guest_or_regular_user_cannot_crud_oils(): void
    {
        // Guests cannot store
        $response = $this->post('/admin/oils', [
            'nama' => 'Shell Advance AX5',
        ]);
        $response->assertStatus(302);

        // Regular user cannot store
        $response = $this->actingAs($this->user)
            ->post('/admin/oils', [
                'nama' => 'Shell Advance AX5',
            ]);
        $response->assertForbidden();
    }
}
