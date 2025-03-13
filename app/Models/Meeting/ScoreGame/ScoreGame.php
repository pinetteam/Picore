<?php

namespace App\Models\Meeting\ScoreGame;

use App\Models\Customer\Customer;
use App\Models\Meeting\Meeting;
use App\Models\Meeting\ScoreGame\Point\Point;
use App\Models\Meeting\ScoreGame\QRCode\QRCode;
use App\Models\System\Setting\Variable\Variable;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ScoreGame extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_score_games';
    protected $fillable = [
        'meeting_id',
        'title',
        'logo',
        'start_at',
        'finish_at',
        'theme',
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
            get: fn (string $startAt) => Carbon::createFromFormat('Y-m-d H:i:s', $startAt)->format($date_time_format),
            set: fn (string $startAt) => Carbon::createFromFormat($date_time_format, $startAt)->format('Y-m-d H:i:s'),
        );
    }
    protected function finishAt(): Attribute
    {
        $time_format = Variable::where('variable','time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value == '24H' ? ' H:i' : ' g:i A';
        $date_time_format = Variable::where('variable','date_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value . $time_format;
        return Attribute::make(
            get: fn (string $finishAt) => Carbon::createFromFormat('Y-m-d H:i:s', $finishAt)->format($date_time_format),
            set: fn (string $finishAt) => Carbon::createFromFormat($date_time_format, $finishAt)->format('Y-m-d H:i:s'),
        );
    }
    public function getCreatedByNameAttribute()
    {
        return isset($this->created_by) ? User::findOrFail($this->created_by)->full_name : __('common.unspecified');
    }
    public function qrCodes(){
        return $this->hasMany(QRCode::class, 'score_game_id', 'id');
    }
    public function meeting(){
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
    public function points(){
        return $this->hasManyThrough(Point::class, QRCode::class, 'score_game_id', 'qr_code_id', 'id', 'id');
    }
}
