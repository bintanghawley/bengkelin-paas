<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    protected $fillable = [
        'invoice_number',
        'amount',
        'payment_method',
        'payment_code',
        'status',
        'expired_at',
        'paid_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * Relationship: A payment has many purchases.
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class, 'payment_id');
    }

    /**
     * Helper to generate a unique invoice number in the format: INV-YYYYMMDD-XXXX
     */
    public static function generateInvoice(): string
    {
        $date = now()->format('Ymd');
        $sequence = 1;
        
        do {
            $invoice = 'INV-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
            $exists = self::where('invoice_number', $invoice)->exists();
            $sequence++;
        } while ($exists);

        return $invoice;
    }
}
