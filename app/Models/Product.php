<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sku',
        'barcode',
        'name',
        'category_id',
        'brand_id',
        'supplier_id',
        'description',
        'unit',
        'purchase_price',
        'selling_price',
        'weight',
        'minimum_stock',
        'maximum_stock',
        'image',
        'is_active',
        'expiry_date',
        'batch_number',
        'tax_rate',
        'notes',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouseStocks()
    {
        return $this->hasMany(WarehouseStock::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function salesOrderItems()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->barcode)) {
                $product->barcode = $product->generateBarcode();
            }
        });
    }

    public function generateBarcode()
    {
        // Generate unique barcode based on SKU and timestamp
        $sku = $this->sku ?? 'PRD';
        $timestamp = now()->format('YmdHis');
        $random = rand(100, 999);
        
        return $sku . $timestamp . $random;
    }

    public function scopeByBarcode($query, $barcode)
    {
        return $query->where('barcode', $barcode);
    }

    public function getBarcodeImageAttribute()
    {
        if (!$this->barcode) {
            return null;
        }

        $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
        return $generator->getBarcode($this->barcode, $generator::TYPE_CODE_128, 2, 50);
    }
}
