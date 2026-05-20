<?php

namespace App\Models;

use App\Models\MeetingAttendance;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'title',
        'meeting_date',
        'start_time',
        'location',
        'description',
    ];

    protected $casts = [
        'meeting_date' => 'date',
    ];

    public function attendances()
    {
        return $this->hasMany(MeetingAttendance::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'meeting_attendances')
            ->withPivot(['status', 'notes'])
            ->withTimestamps();
    }
}
