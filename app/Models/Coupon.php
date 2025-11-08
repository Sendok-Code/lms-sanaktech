<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'max_uses',
        'used_count',
        'min_purchase',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function isValid($coursePrice = 0)
    {
        // Check if active
        if (!$this->is_active) {
            return false;
        }

        // Check if expired
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        // Check if max uses reached
        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return false;
        }

        // Check minimum purchase
        if ($coursePrice < $this->min_purchase) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($coursePrice)
    {
        if ($this->type === 'percentage') {
            return ($coursePrice * $this->value) / 100;
        }

        return min($this->value, $coursePrice);
    }

    public function incrementUsage()
    {
        $this->increment('used_count');
    }
}
