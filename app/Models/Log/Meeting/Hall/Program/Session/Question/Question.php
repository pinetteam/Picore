<?php

namespace App\Models\Log\Meeting\Hall\Program\Session\Question;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_hall_program_session_question_logs';
    protected $fillable = [
        'question_id',
        'action',
        'created_by',
    ];
    protected $dates = [
        'created_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
    ];
    public function question()
    {
        return $this->belongsTo(\App\Models\Meeting\Hall\Program\Session\Question\Question::class, 'question_id', 'id');
    }
}
