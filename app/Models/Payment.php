<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id',
        'customer_id',
        'payment_number',
        'payment_date',
        'payment_method',
        'bank_name',
        'account_number',
        'account_name',
        'amount',
        'status',
        'proof_image',
        'notes',
        'verified_by',
        'verified_at',
        'rejection_reason',
        'created_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}