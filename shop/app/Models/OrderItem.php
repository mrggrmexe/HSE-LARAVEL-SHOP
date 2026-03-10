<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'unit_price',
        'line_total',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'line_total' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (OrderItem $item): void {
            if (blank($item->product_name) && $item->product) {
                $item->product_name = $item->product->name;
            }

            $item->line_total = number_format(((float) $item->unit_price) * $item->quantity, 2, '.', '');
        });

        static::saved(function (OrderItem $item): void {
            $item->order?->recalculateTotal();
        });

        static::deleted(function (OrderItem $item): void {
            $item->order?->recalculateTotal();
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}