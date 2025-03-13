<?php

namespace App\Models\Meeting\Hall\Program\Debate\Vote;

use App\Models\Customer\Customer;
use App\Models\Meeting\Hall\Program\Debate\Debate;
use App\Models\Meeting\Hall\Program\Debate\Team\Team;
use App\Models\Meeting\Participant\Participant;
use App\Models\System\Setting\Variable\Variable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Vote extends Model
{
    protected $table = 'meeting_hall_program_debate_votes';
    protected $fillable = [
        'debate_id',
        'team_id',
        'participant_id',
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
    protected function createdAt(): Attribute
    {
        $time_format = Variable::where('variable','time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value == '24H' ? ' H:i' : ' g:i A';
        $date_time_format = Variable::where('variable','date_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value . $time_format;
        return Attribute::make(
            get: fn ($createdAt) => $createdAt ? Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->format($date_time_format) : null,
            );
    }
    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id');
    }
    public function debate()
    {
        return $this->belongsTo(Debate::class, 'debate_id', 'id');
    }
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
}
