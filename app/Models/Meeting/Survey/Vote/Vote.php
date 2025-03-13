<?php

namespace App\Models\Meeting\Survey\Vote;

use App\Models\Customer\Customer;
use App\Models\Meeting\Participant\Participant;
use App\Models\Meeting\Survey\Question\Option\Option;
use App\Models\Meeting\Survey\Question\Question;
use App\Models\Meeting\Survey\Survey;
use App\Models\System\Setting\Variable\Variable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Vote extends Model
{
    protected $table = 'meeting_survey_votes';
    protected $fillable = [
        'survey_id',
        'question_id',
        'option_id',
        'participant_id',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected function createdAt(): Attribute
    {
        $time_format = Variable::where('variable','time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value == '24H' ? ' H:i' : ' g:i A';
        $date_time_format = Variable::where('variable','date_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value . $time_format;

        return Attribute::make(
            get: fn ($createdAt) => $createdAt ? Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->format($date_time_format) : null,
            );
    }
    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id', 'id');
    }
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'id');
    }
    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id');
    }
}

