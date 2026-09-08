<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MechanicAssistanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'emergency_report_id',
        'requester_mechanic_id',
        'target_mechanic_id',
        'needed_item',
        'reason',
        'location_detail',
        'maps_url',
        'status',
        'response_note',
        'responded_at',
        'completed_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function emergencyReport(): BelongsTo
    {
        return $this->belongsTo(EmergencyReport::class);
    }

    public function requesterMechanic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_mechanic_id');
    }

    public function targetMechanic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_mechanic_id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public static function statusLabel(string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu Respons',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $status,
        };
    }

    public static function statusColor(string $status): string
    {
        return match ($status) {
            'pending' => 'yellow',
            'accepted' => 'emerald',
            'rejected' => 'red',
            'completed' => 'blue',
            'cancelled' => 'zinc',
            default => 'zinc',
        };
    }
}
