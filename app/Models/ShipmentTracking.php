<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentTracking extends Model
{
    protected $fillable = [
        'shipment_id',
        'status',
        'location',
        'description',
        'tracking_date',
    ];

    protected $casts = [
        'tracking_date' => 'datetime',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}