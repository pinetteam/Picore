<?php

namespace App\Models\Meeting\Hall\Program;

use App\Models\Customer\Customer;
use App\Models\Meeting\Hall\Hall;
use App\Models\Meeting\Hall\Program\Chair\Chair;
use App\Models\Meeting\Hall\Program\Debate\Debate;
use App\Models\Meeting\Hall\Program\Session\Session;
use App\Models\Meeting\Participant\Participant;
use App\Models\System\Setting\Variable\Variable;
//use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Program extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_hall_programs';
    protected $fillable = [
        'hall_id',
        'sort_order',
        'code',
        'title',
        'description',
        'logo_name',
        'logo_extension',
        'start_at',
        'finish_at',
        'type',
        'is_started',
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
        return Attribute::make(
            get: function ($value) {
                if (!$value) return null;
                return Carbon::parse($value);
            },
            set: function ($value) {
                if (!$value) return null;
                if ($value instanceof Carbon) {
                    return $value->format('Y-m-d H:i:s');
                }
                return Carbon::parse($value)->format('Y-m-d H:i:s');
            }
        );
    }

    protected function finishAt(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (!$value) return null;
                return Carbon::parse($value);
            },
            set: function ($value) {
                if (!$value) return null;
                if ($value instanceof Carbon) {
                    return $value->format('Y-m-d H:i:s');
                }
                return Carbon::parse($value)->format('Y-m-d H:i:s');
            }
        );
    }
    public function getCreatedByNameAttribute()
    {
        return isset($this->created_by) ? User::findOrFail($this->created_by)->full_name : __('common.unspecified');
    }
    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id', 'id');
    }
    public function programChairs()
    {
        return $this->hasMany(Chair::class, 'program_id', 'id');
    }
    public function chairs()
    {
        return $this->belongsToMany(Participant::class, 'meeting_hall_program_chairs', 'program_id', 'chair_id')->where('meeting_hall_program_chairs.deleted_by', null);
    }
    public function sessions()
    {
        return $this->hasMany(Session::class, 'program_id', 'id');
    }
    public function debates()
    {
        return $this->hasMany(Debate::class, 'program_id', 'id');
    }
}
