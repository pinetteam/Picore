<?php

namespace App\Models\Meeting\Hall\Program\Chair;

use App\Models\Meeting\Hall\Program\Program;
use App\Models\Meeting\Participant\Participant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chair extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_hall_program_chairs';
    protected $fillable = [
        'sort_order',
        'program_id',
        'chair_id',
        'type',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function chair()
    {
        return $this->belongsTo(Participant::class, 'chair_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
}
