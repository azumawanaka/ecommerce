<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order',
        'max_discount',
        'usage_limit',
        'used_count',
        'starts_at',
        'ends_at',
        'status', // 'active', 'inactive', 'expired'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function isValid(): bool
    {
        $now = now();
        return $this->status === 'active' &&
               ($this->starts_at === null || $this->starts_at <= $now) &&
               ($this->ends_at === null || $this->ends_at >= $now) &&
               ($this->usage_limit === 0 || $this->used_count < $this->usage_limit);
    }

    public function incrementUsage(): void
    {
        $this->increment('used_count');
        if ($this->usage_limit > 0 && $this->used_count >= $this->usage_limit) {
            $this->status = 'expired';
            $this->save();
        }
    }

    public function decrementUsage(): void
    {
        if ($this->used_count > 0) {
            $this->decrement('used_count');
            if ($this->status === 'expired' && ($this->usage_limit === 0 || $this->used_count < $this->usage_limit)) {
                $this->status = 'active';
                $this->save();
            }
        }
    }

    public function calculateDiscount(float $orderTotal): float
    {
        if (!$this->isValid() || $orderTotal < $this->min_order) {
            return 0.0;
        }

        if ($this->type === 'fixed') {
            return min($this->value, $orderTotal);
        } elseif ($this->type === 'percent') {
            $discount = ($this->value / 100) * $orderTotal;
            if ($this->max_discount !== null) {
                return min($discount, $this->max_discount);
            }
            return $discount;
        }

        return 0.0;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where(function ($q) {
                         $now = now();
                         $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
                     })
                     ->where(function ($q) {
                         $now = now();
                         $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
                     })
                     ->where(function ($q) {
                         $q->where('usage_limit', 0)->orWhereColumn('used_count', '<', 'usage_limit');
                     });
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
                     ->orWhere(function ($q) {
                         $now = now();
                         $q->whereNotNull('ends_at')->where('ends_at', '<', $now);
                     })
                     ->orWhereColumn('used_count', '>=', 'usage_limit');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
