<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'npwp',
        'tax_id',
        'sales_id',
        'credit_limit',
        'payment_terms',
        'current_balance',
        'is_active',
        'is_taxable',
        'latitude',
        'longitude',
        'notes',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'payment_terms' => 'integer',
        'is_active' => 'boolean',
    ];

    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }

    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
