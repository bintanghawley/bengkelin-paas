<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nomor_telepon',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [];
    }

    public function setNameAttribute(string $value): void
    {
        $normalized = trim(preg_replace('/\s+/', ' ', $value));
        $this->attributes['name'] = ucwords(strtolower($normalized));
    }

    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class, 'user_id');
    }

    public function emergencyReports(): HasMany
    {
        return $this->hasMany(EmergencyReport::class, 'user_id');
    }

    public function mechanicBookings(): HasMany
    {
        return $this->hasMany(ServiceBooking::class, 'mechanic_id');
    }

    public function sentAssistanceRequests(): HasMany
    {
        return $this->hasMany(MechanicAssistanceRequest::class, 'requester_mechanic_id');
    }

    public function receivedAssistanceRequests(): HasMany
    {
        return $this->hasMany(MechanicAssistanceRequest::class, 'target_mechanic_id');
    }
}
