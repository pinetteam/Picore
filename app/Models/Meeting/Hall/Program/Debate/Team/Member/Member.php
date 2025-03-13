<?php

namespace App\Models\Meeting\Hall\Program\Debate\Team\Member;

use App\Models\Meeting\Hall\Program\Debate\Team\Team;
use App\Models\Meeting\Participant\Participant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_hall_program_debate_team_members';
    protected $fillable = [
        'sort_order',
        'team_id',
        'member_id',
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
    public function member()
    {
        return $this->belongsTo(Participant::class, 'member_id', 'id');
    }
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
}
