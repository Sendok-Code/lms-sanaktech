<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'enrollment_id',
        'coupon_id',
        'amount',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'tax_rate',
        'currency',
        'status',
        'payment_method',
        'metadata',
        'snap_token',
        'transaction_id',
        'transaction_status',
        'fraud_status',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'metadata' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the course through enrollment
     */
    public function course()
    {
        return $this->hasOneThrough(
            Course::class,
            Enrollment::class,
            'id',           // Foreign key on enrollments table
            'id',           // Foreign key on courses table
            'enrollment_id', // Local key on payments table
            'course_id'      // Local key on enrollments table
        );
    }
}
