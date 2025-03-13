<?php

namespace App\Models\Meeting\Hall\Program\Session\Question;

use App\Models\Meeting\Hall\Program\Session\Session;
use App\Models\Meeting\Participant\Participant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_hall_program_session_questions';
    protected $fillable = [
        'sort_order',
        'session_id',
        'questioner_id',
        'question',
        'is_hidden_name',
        'selected_for_show',
        'created_by',
        'updated_by',
        'deleted_by',
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
    public function programSession()
    {
        return $this->belongsTo(Session::class, 'session_id', 'id');
    }
    public function questioner()
    {
        return $this->belongsTo(Participant::class, 'questioner_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(\App\Models\Log\Meeting\Hall\Program\Session\Question\Question::class,'question_id','id');
    }
}
