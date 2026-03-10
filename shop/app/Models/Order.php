<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_PAID,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELLED,
    ];

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'ordered_at',
        'total_amount',
    ];

    protected function casts(): array
    {
        return [
            'ordered_at' => 'datetime',
            'total_amount' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Order $order): void {
            if (blank($order->order_number)) {
                $order->order_number = 'ORD-'.now()->format('YmdHis').'-'.str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
            }

            if (blank($order->ordered_at)) {
                $order->ordered_at = now();
            }

            if (blank($order->status)) {
                $order->status = self::STATUS_PENDING;
            }

            if (blank($order->total_amount)) {
                $order->total_amount = 0;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function recalculateTotal(): void
    {
        $total = (float) $this->items()->sum('line_total');

        $this->forceFill([
            'total_amount' => number_format($total, 2, '.', ''),
        ])->saveQuietly();
    }
}