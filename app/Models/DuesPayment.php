<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DuesPayment extends Model
{
    protected $fillable = [
        'member_id',
        'dues_year',
        'amount_due',
        'amount_paid',
        'paid_at',
        'payment_method',
        'receipt_number',
        'status',
        'notes',
    ];

    protected $casts = [
        'paid_at' => 'date',
        'amount_due' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function getBalanceAttribute(): float
    {
        return (float) $this->amount_due - (float) $this->amount_paid;
    }
}
