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
        if ($this->gambar && $this->gambar !== '0') {
            if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://')) {
                return $this->gambar;
            }
            if (str_starts_with($this->gambar, 'img/')) {
                return asset($this->gambar);
            }
            // 1. If file exists on local public storage, serve directly
            if (file_exists(storage_path('app/public/' . $this->gambar))) {
                return asset('storage/' . $this->gambar);
            }
            // 2. Otherwise if S3 is configured, generate cloud URL
            $disk = config('filesystems.default', 'public');
            if ($disk === 's3' && config('filesystems.disks.s3.key') && !str_starts_with($this->gambar, 'public/')) {
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
        return asset('img/Gemini_Generated_Image_m0vuzjm0vuzjm0vu.png');
    }
}
