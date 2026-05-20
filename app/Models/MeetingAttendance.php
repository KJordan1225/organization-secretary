<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingAttendance extends Model
{
    protected $fillable = [
        'meeting_id',
        'member_id',
        'status',
        'notes',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
