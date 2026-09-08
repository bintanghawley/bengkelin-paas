<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tire extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga',
        'stok',
        'gambar',
        'deskripsi',
        'jenis_ban',
        'merek',
        'ukuran_ban',
        'posisi_ban',
        'material',
        'diameter',
        'tipe',
        'fitur',
    ];

    /**
     * Accessor untuk URL gambar
     */
    public function getImageUrlAttribute()
    {
        if (!$this->gambar) {
            return null;
        }

        if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://')) {
            return $this->gambar;
        }

        if (str_starts_with($this->gambar, 'img/')) {
            return asset($this->gambar);
        }

        $disk = config('filesystems.default', 'public');
        if ($disk === 's3') {
            return \Illuminate\Support\Facades\Storage::disk('s3')->url($this->gambar);
        }

        return asset('storage/' . $this->gambar);
    }
}
