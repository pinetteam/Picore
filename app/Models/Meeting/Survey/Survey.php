<?php

namespace App\Models\Meeting\Survey;

use App\Models\Customer\Customer;
use App\Models\Meeting\Meeting;
use App\Models\Meeting\Survey\Question\Option\Option;
use App\Models\Meeting\Survey\Question\Question;
use App\Models\Meeting\Survey\Vote\Vote;
use App\Models\System\Setting\Variable\Variable;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Survey extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_surveys';
    protected $fillable = [
        'sort_order',
        'meeting_id',
        'title',
        'description',
        'start_at',
        'finish_at',
        'on_vote',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'start_at',
        'finish_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'start_at' => 'datetime',
        'finish_at' => 'datetime',
    ];
    protected function startAt(): Attribute
    {
        $time_format = Variable::where('variable','time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value == '24H' ? ' H:i' : ' g:i A';
        $date_time_format = Variable::where('variable','date_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value . $time_format;
        return Attribute::make(
            get: fn ($startAt) => $startAt ? Carbon::createFromFormat('Y-m-d H:i:s', $startAt)->format($date_time_format) : null,
            set: fn ($startAt) => $startAt ? Carbon::createFromFormat($date_time_format, $startAt)->format('Y-m-d H:i:s') : null,
        );
    }
    protected function finishAt(): Attribute
    {
        $time_format = Variable::where('variable','time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value == '24H' ? ' H:i' : ' g:i A';
        $date_time_format = Variable::where('variable','date_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value . $time_format;
        return Attribute::make(
            get: fn ($finishAt) => $finishAt ? Carbon::createFromFormat('Y-m-d H:i:s', $finishAt)->format($date_time_format) : null,
            set: fn ($finishAt) => $finishAt ? Carbon::createFromFormat($date_time_format, $finishAt)->format('Y-m-d H:i:s') : null,
        );
    }
    public function questions()
    {
        return $this->hasMany(Question::class, 'survey_id', 'id');
    }
    public function votes()
    {
        return $this->hasMany(Vote::class, 'survey_id', 'id');
    }
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
    public function options()
    {
        return $this->hasManyThrough(Option::class, Question::class, 'survey_id', 'question_id', 'id');
    }
}
