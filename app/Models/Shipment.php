<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'sales_order_id',
        'shipment_number',
        'shipping_date',
        'estimated_delivery_date',
        'actual_delivery_date',
        'carrier',
        'tracking_number',
        'shipping_cost',
        'status',
        'notes',
    ];

    protected $casts = [
        'shipping_date' => 'date',
        'estimated_delivery_date' => 'date',
        'actual_delivery_date' => 'date',
        'shipping_cost' => 'decimal:2',
    ];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function items()
    {
        return $this->hasMany(ShipmentItem::class);
    }

    public function trackings()
    {
        return $this->hasMany(ShipmentTracking::class);
    }
}