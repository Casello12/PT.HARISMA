<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'name',
        'email',
        'phone',
        'address',
        'region',
        'commission_rate',
        'target_sales',
        'current_sales',
        'is_active',
        'join_date',
        'notes',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'target_sales' => 'decimal:2',
        'current_sales' => 'decimal:2',
        'is_active' => 'boolean',
        'join_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }
}
