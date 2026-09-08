<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    protected $fillable = [
        'user_id',
        'barang_id',
        'barang_nama',
        'harga',
        'jumlah',
        'total_harga',
        'alamat',
        'telepon',
        'metode_pembayaran',
        'catatan',
        'status',
        'payment_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    /**
     * Get a consistent unique reference code (e.g. PB260609xxxxxxxx)
     */
    public function getReferenceCode(): string
    {
        $hash = abs(crc32($this->id . 'bengkelin-purchase'));
        return 'PB' . $this->created_at->format('ymd') . str_pad($hash, 8, '0', STR_PAD_LEFT);
    }

    /**
     * Dynamically resolve product image from Tire, Oil, or Sparepart tables
     */
    public function getImageUrl(): ?string
    {
        // Try searching in Tire by ID and name
        $tire = \App\Models\Tire::find($this->barang_id);
        if ($tire && $tire->nama === $this->barang_nama) {
            return $this->resolvePath($tire->gambar);
        }

        // Try searching in Oil by ID and name
        $oil = \App\Models\Oil::find($this->barang_id);
        if ($oil && $oil->nama === $this->barang_nama) {
            return $this->resolvePath($oil->gambar);
        }

        // Try searching in Sparepart by ID and name
        $sparepart = \App\Models\Sparepart::find($this->barang_id);
        if ($sparepart && $sparepart->nama === $this->barang_nama) {
            return $this->resolvePath($sparepart->gambar);
        }

        // Try searching by name fallback
        $tireByName = \App\Models\Tire::where('nama', $this->barang_nama)->first();
        if ($tireByName) {
            return $this->resolvePath($tireByName->gambar);
        }

        $oilByName = \App\Models\Oil::where('nama', $this->barang_nama)->first();
        if ($oilByName) {
            return $this->resolvePath($oilByName->gambar);
        }

        $sparepartByName = \App\Models\Sparepart::where('nama', $this->barang_nama)->first();
        if ($sparepartByName) {
            return $this->resolvePath($sparepartByName->gambar);
        }

        // Try generic Product model as last resort
        $product = \App\Models\Product::find($this->barang_id);
        if ($product && $product->nama === $this->barang_nama) {
            return $this->resolvePath($product->gambar);
        }
        $productByName = \App\Models\Product::where('nama', $this->barang_nama)->first();
        if ($productByName) {
            return $this->resolvePath($productByName->gambar);
        }

        return null;
    }

    private function resolvePath($gambar): ?string
    {
        if (!$gambar) return null;
        if (str_starts_with($gambar, 'img/') || str_starts_with($gambar, 'http')) {
            return asset($gambar);
        }
        return asset('storage/' . $gambar);
    }
}
