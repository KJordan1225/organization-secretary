<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    protected $fillable = [
        'transaction_type',
        'category',
        'amount',
        'transaction_date',
        'payment_method',
        'reference_number',
        'payee',
        'payer',
        'status',
        'description',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2);
    }
}
