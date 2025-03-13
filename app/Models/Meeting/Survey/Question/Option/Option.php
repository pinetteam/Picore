<?php

namespace App\Models\Meeting\Survey\Question\Option;


use App\Models\Meeting\Survey\Question\Question;
use App\Models\Meeting\Survey\Vote\Vote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_survey_question_options';
    protected $fillable = [
        'sort_order',
        'survey_id',
        'question_id',
        'option',
        'status',
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
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
    public function votes()
    {
        return $this->hasMany(Vote::class, 'option_id', 'id');
    }
}
