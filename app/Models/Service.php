<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'harga_mulai',
        'estimasi_waktu',
        'gambar',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->nama);
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('nama') && empty($service->slug)) {
                $service->slug = Str::slug($service->nama);
            }
        });
    }

    public function items()
    {
        return $this->hasMany(ServiceItem::class);
    }

    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class, 'service_id');
    }

    public function getHargaMulaiFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_mulai, 0, ',', '.');
    }

    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar) {
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
        return asset('img/Gemini_Generated_Image_m0vuzjm0vuzjm0vu.png');
    }
}
