<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'name',
        'code',
        'discount_type',
        'discount_value',
        'min_cart_value',
        'max_discount_amount',
        'start_date',
        'end_date',
        'total_usage_limit',
        'per_user_usage_limit',
        'times_used',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'min_cart_value' => 'decimal:2',
            'max_discount_amount' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function isValid(float $cartTotal, ?int $userId = null, ?string $email = null): array
    {
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'This coupon is not active.'];
        }

        if ($this->start_date && now()->lt($this->start_date)) {
            return ['valid' => false, 'message' => 'This coupon is not yet active.'];
        }

        if ($this->end_date && now()->gt($this->end_date->endOfDay())) {
            return ['valid' => false, 'message' => 'This coupon has expired.'];
        }

        if ($this->total_usage_limit && $this->times_used >= $this->total_usage_limit) {
            return ['valid' => false, 'message' => 'This coupon has reached its usage limit.'];
        }

        if ($cartTotal < $this->min_cart_value) {
            return ['valid' => false, 'message' => 'Minimum cart value of ₹' . number_format($this->min_cart_value) . ' required.'];
        }

        if ($this->per_user_usage_limit > 0) {
            $userUsage = $this->usages()
                ->when($userId, fn($q) => $q->where('user_id', $userId))
                ->when(!$userId && $email, fn($q) => $q->where('customer_email', $email))
                ->count();

            if ($userUsage >= $this->per_user_usage_limit) {
                return ['valid' => false, 'message' => 'You have already used this coupon.'];
            }
        }

        return ['valid' => true, 'message' => 'Coupon applied successfully!'];
    }

    public function calculateDiscount(float $cartTotal): float
    {
        if ($this->discount_type === 'percentage') {
            $discount = ($cartTotal * $this->discount_value) / 100;
            if ($this->max_discount_amount) {
                $discount = min($discount, $this->max_discount_amount);
            }
        } else {
            $discount = $this->discount_value;
        }

        return min($discount, $cartTotal);
    }
}
