<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    protected $fillable = [
        'service_id',
        'nama_pekerjaan',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
