<?php

namespace Tests\Feature;

use App\Models\Purchase;
use App\Models\Sparepart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SparepartTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private User $admin;

    private Sparepart $sparepart;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Sparepart Customer',
            'nomor_telepon' => '081234567895',
            'password' => Hash::make('123456'),
            'role' => 'pengguna',
        ]);

        $this->admin = User::create([
            'name' => 'Admin Boss',
            'nomor_telepon' => '081234567890',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        $this->sparepart = Sparepart::create([
            'nama' => 'Aki Kering GTZ-5S X-Grade 12V 5Ah',
            'harga' => 185000,
            'stok' => 15,
            'gambar' => null,
            'jenis_sparepart' => 'aki motor',
            'merek' => 'X-Grade',
            'fitur' => 'Tegangan stabil 12V, Bebas perawatan',
            'deskripsi' => 'Aki kering GTZ-5S premium.',
        ]);
    }

    public function test_catalog_page_loads_and_displays_spareparts(): void
    {
        $response = $this->get(route('toko.sparepart'));

        $response->assertStatus(200);
        $response->assertSee('Aki Kering GTZ-5S');
    }

    public function test_detail_page_loads_and_displays_sparepart_specs(): void
    {
        $response = $this->get(route('toko.sparepart.show', $this->sparepart->id));

        $response->assertStatus(200);
        $response->assertSee('Aki Kering GTZ-5S');
        $response->assertSee('aki motor');
        $response->assertSee('X-Grade');
    }

    public function test_authenticated_user_can_access_checkout_and_buy_sparepart(): void
    {
        // 1. Checkout view
        $response = $this->actingAs($this->user)
            ->get(route('toko.sparepart.checkout', $this->sparepart->id));
        $response->assertStatus(200);

        // 2. Post Buy request
        $response = $this->actingAs($this->user)
            ->post(route('toko.sparepart.buy', $this->sparepart->id), [
                'jumlah' => 2,
                'alamat' => 'Jl. Sparepart No. 45, Jakarta',
                'telepon' => '081234567895',
                'metode_pembayaran' => 'COD',
                'catatan' => 'Minta paking tebal',
            ]);

        $purchase = Purchase::first();
        $this->assertNotNull($purchase);

        $response->assertRedirect(route('toko.result', $purchase->id));

        // Assert stock decrement
        $this->assertEquals(13, $this->sparepart->fresh()->stok);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $this->user->id,
            'barang_id' => $this->sparepart->id,
            'barang_nama' => 'Aki Kering GTZ-5S X-Grade 12V 5Ah',
            'jumlah' => 2,
            'total_harga' => 370000,
            'alamat' => 'Jl. Sparepart No. 45, Jakarta',
            'status' => 'diproses',
        ]);
    }

    public function test_admin_can_crud_spareparts(): void
    {
        // 1. Create sparepart (store)
        $response = $this->actingAs($this->admin)
            ->post('/admin/spareparts', [
                'nama' => 'Filter Udara Vario X-Ten',
                'harga' => 45000,
                'stok' => 20,
                'jenis_sparepart' => 'filter udara motor',
                'merek' => 'X-Ten',
                'fitur' => 'Serat kertas khusus filtrasi mikro',
                'deskripsi' => 'Filter udara handal.',
            ]);

        $response->assertStatus(302); // redirect back
        $this->assertDatabaseHas('spareparts', [
            'nama' => 'Filter Udara Vario X-Ten',
            'merek' => 'X-Ten',
            'stok' => 20,
        ]);

        $newSp = Sparepart::where('nama', 'Filter Udara Vario X-Ten')->first();

        // 2. Update sparepart (update)
        $response = $this->actingAs($this->admin)
            ->put('/admin/spareparts/'.$newSp->id, [
                'nama' => 'Filter Udara Vario X-Ten Updated',
                'harga' => 48000,
                'stok' => 22,
                'jenis_sparepart' => 'filter udara motor',
                'merek' => 'X-Ten',
                'fitur' => 'Serat kertas khusus filtrasi mikro',
                'deskripsi' => 'Filter udara handal updated.',
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('spareparts', [
            'id' => $newSp->id,
            'nama' => 'Filter Udara Vario X-Ten Updated',
            'harga' => 48000,
            'stok' => 22,
        ]);

        // 3. Delete sparepart (destroy)
        $response = $this->actingAs($this->admin)
            ->delete('/admin/spareparts/'.$newSp->id);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('spareparts', [
            'id' => $newSp->id,
        ]);
    }

    public function test_guest_or_regular_user_cannot_crud_spareparts(): void
    {
        // Guests cannot store
        $response = $this->post('/admin/spareparts', [
            'nama' => 'Aki Motor Abal-abal',
        ]);
        $response->assertStatus(302);

        // Regular user cannot store
        $response = $this->actingAs($this->user)
            ->post('/admin/spareparts', [
                'nama' => 'Aki Motor Abal-abal',
            ]);
        $response->assertForbidden();
    }
}
