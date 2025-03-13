<?php

namespace App\Models\Meeting\Participant;

use App\Models\Log\Meeting\Participant\DailyAccess\DailyAccess;
use App\Models\Meeting\Hall\Program\Session\Question\Question;
use App\Models\Meeting\Meeting;
use App\Models\Meeting\ScoreGame\Point\Point;
use App\Models\System\Country\Country;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Participant extends Model
{
    use HasApiTokens, SoftDeletes, Notifiable;
    protected $table = 'meeting_participants';
    protected $fillable = [
        'meeting_id',
        'username',
        'title',
        'first_name',
        'last_name',
        'identification_number',
        'organisation',
        'email',
        'phone_country_id',
        'phone',
        'password',
        'last_login_ip',
        'last_login_agent',
        'last_login_datetime',
        'last_activity',
        'type',
        'enrolled',
        'enrolled_at',
        'gdpr_consent',
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
        'last_login_datetime',
        'last_activity',
        'enrolled_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'last_login_datetime' => 'datetime',
        'last_activity' => 'timestamp',
        'enrolled_at' => 'timestamp',
    ];
    protected $perPage = 30;
    public function routeNotificationFor($channel)
    {
        if ($channel === 'pusher_beams') {
            return 'meeting-' . $this->meeting->id . '-' . $this->type . '-' . $this->id;
        }
    }
    public function scopeSearchByName($query, $name)
    {
        return $query->where(function($q) use ($name) {
            $q->where('first_name', 'LIKE', '%' . $name . '%')
                ->orWhere('last_name', 'LIKE', '%' . $name . '%');
        });
    }
    public function getActivityStatusAttribute()
    {
        if($this->last_activity !== null) {
            $now = Carbon::now()->timestamp;
            $last_activity = $this->last_activity;
            $diff_in_seconds = $now-$last_activity;
            if($diff_in_seconds<300) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function phoneCountry()
    {
        return $this->belongsTo(Country::class, 'phone_country_id', 'id');
    }
    public function getFullPhoneAttribute()
    {
        return (isset($this->phone_country_id) && isset($this->phone)) ? Str::of('+'.$this->phoneCountry->phone_code.$this->phone)->trim() : __('common.unspecified');
    }
    public function getIdentificationNumberShowAttribute()
    {
        return isset($this->identification_number) ? $this->identification_number : __('common.unspecified');
    }
    public function getOrganisationShowAttribute()
    {
        return isset($this->organisation) ? $this->organisation : __('common.unspecified');
    }
    public function getLastLoginAttribute()
    {
        return isset($this->last_login_datetime) ? Carbon::parse($this->last_login_datetime)->diffForHumans() : __('common.not-logged-in-yet');
    }
    public function getLastUserActivityAttribute()
    {
        return $this->logs()->count() > 0 ? Carbon::parse($this->logs()->latest()->first()->created_at)->diffForHumans() : __('common.not-logged-in-yet');
    }
    public function getFullNameAttribute()
    {
        return Str::of("$this->title $this->first_name $this->last_name")->trim();
    }
    public function getTotalScoreGamePoint(int $score_game_id)
    {
        return Point::where([['participant_id', $this->id]])->sum('point');
    }
    public function sessionQuestions()
    {
        return $this->hasMany(Question::class, 'questioner_id', 'id');
    }
    public function logs()
    {
        return $this->hasMany(\App\Models\Log\Meeting\Participant\Participant::class, 'participant_id', 'id');
    }
    public function dailyAccesses()
    {
        return $this->hasMany(DailyAccess::class, 'participant_id', 'id');
    }
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
}
