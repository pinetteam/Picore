<?php

namespace App\Models\Log\Meeting\Participant\DailyAccess;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyAccess extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_participant_daily_accesses';
    protected $fillable = [
        'participant_id',
        'day',
    ];
    protected $dates = [
        'day',
        'created_at',
    ];
    protected $casts = [
        'day' => 'datetime',
        'created_at' => 'datetime',
    ];
    public function participant()
    {
        return $this->belongsTo(\App\Models\Meeting\Participant\Participant::class, 'participant_id', 'id');
    }
}
