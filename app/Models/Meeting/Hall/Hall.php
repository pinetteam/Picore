<?php

namespace App\Models\Meeting\Hall;

use App\Models\Meeting\Hall\Program\Debate\Debate;
use App\Models\Meeting\Hall\Program\Program;
use App\Models\Meeting\Hall\Program\Session\Session;
use App\Models\Meeting\Hall\Screen\Screen;
use App\Models\Meeting\Meeting;
//use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hall extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_halls';
    protected $fillable = [
        'meeting_id',
        'code',
        'title',
        'show_on_session',
        'show_on_ask_question',
        'show_on_view_program',
        'show_on_send_mail',
        'status',
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
    public function getCreatedByNameAttribute()
    {
        return isset($this->created_by) ? User::findOrFail($this->created_by)->full_name : __('common.unspecified');
    }
    public function programs()
    {
        return $this->hasMany(Program::class, 'hall_id', 'id');
    }
    public function screens()
    {
        return $this->hasMany(Screen::class, 'hall_id', 'id');
    }
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
    public function programSessions()
    {
        return $this->hasManyThrough(Session::class, Program::class, 'hall_id', 'program_id', 'id');
    }
    public function debates()
    {
        return $this->hasManyThrough(Debate::class, Program::class, 'hall_id', 'program_id', 'id');
    }
}
