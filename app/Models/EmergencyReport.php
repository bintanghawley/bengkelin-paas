<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EmergencyReport extends Model
{
    protected $fillable = [
        'user_id',
        'mechanic_id',
        'nama_kendaraan',
        'plat_nomor',
        'keluhan',
        'latitude',
        'longitude',
        'lokasi_detail',
        'status',
        'catatan_mekanik',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public static function statusList(): array
    {
        return ['pending', 'diterima', 'dalam_perjalanan', 'sampai_lokasi', 'selesai', 'ditolak', 'dibatalkan'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mechanic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mechanic_id');
    }

    public function assistanceRequests(): HasMany
    {
        return $this->hasMany(MechanicAssistanceRequest::class);
    }

    public function activeAssistanceRequest(): HasOne
    {
        return $this->hasOne(MechanicAssistanceRequest::class)
            ->whereIn('status', ['pending', 'accepted'])
            ->latestOfMany();
    }
}
