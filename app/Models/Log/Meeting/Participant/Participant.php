<?php

namespace App\Models\Log\Meeting\Participant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_participant_logs';
    protected $fillable = [
        'participant_id',
        'action',
        'object',
    ];
    protected $dates = [
        'created_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
    ];
    public function participant()
    {
        return $this->belongsTo(\App\Models\Meeting\Participant\Participant::class, 'participant_id', 'id');
    }
}
