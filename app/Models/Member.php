<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'member_number',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'email',
        'phone',
        'alternate_phone',
        'date_of_birth',
        'joined_at',
        'membership_status',
        'membership_type',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joined_at' => 'date',
    ];

    public function getFullNameAttribute(): string
    {
        return trim(
            "{$this->first_name} {$this->middle_name} {$this->last_name} {$this->suffix}"
        );
    }
}
