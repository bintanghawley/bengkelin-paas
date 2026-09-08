<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga',
        'stok',
        'deskripsi',
        'gambar',
        'kategori',
    ];

    /**
     * Accessor untuk URL gambar
     */
    public function getImageUrlAttribute()
    {
        if (!$this->gambar || $this->gambar === '0') {
            return null;
        }

        if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://')) {
            return $this->gambar;
        }

        if (str_starts_with($this->gambar, 'img/')) {
            return asset($this->gambar);
        }

        $disk = config('filesystems.default', 'public');
        if ($disk === 's3' && !str_starts_with($this->gambar, 'public/')) {
            try {
                return \Illuminate\Support\Facades\Storage::disk('s3')->temporaryUrl($this->gambar, now()->addHours(24));
            } catch (\Throwable $e) {
                try {
                    return \Illuminate\Support\Facades\Storage::disk('s3')->url($this->gambar);
                } catch (\Throwable $e2) {
                    return asset('storage/' . $this->gambar);
                }
            }
        }

        return asset('storage/' . $this->gambar);
    }
}