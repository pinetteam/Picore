<?php

namespace App\Models\Log\Meeting\Hall\Program\Session;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_hall_program_session_logs';
    protected $fillable = [
        'session_id',
        'action',
        'created_by',
    ];
    protected $dates = [
        'created_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
    ];
    public function session()
    {
        return $this->belongsTo(\App\Models\Meeting\Hall\Program\Session\Session::class, 'session_id', 'id');
    }
}
