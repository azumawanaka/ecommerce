<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'status',
        'total_amount',
        'subtotal_amount',
        'discount_amount',
        'shipping_amount',
        'tax_amount',
        'payment_status',
        'payment_method',
        'shipping_address_id',
        'billing_address_id',
        'placed_at',
    ];

    protected $casts = [
        'placed_at' => 'datetime',
        'total_amount' => 'decimal:2',
        'subtotal_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
