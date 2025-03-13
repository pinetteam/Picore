<?php

namespace App\Models\Meeting\Hall\Screen;

use App\Models\Meeting\Hall\Hall;
use App\Models\Meeting\Hall\Program\Debate\Debate;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use App\Models\Meeting\Hall\Screen\Timer\Timer;
use App\Models\Meeting\Participant\Participant;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Screen extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_hall_screens';
    protected $fillable = [
        'hall_id',
        'code',
        'title',
        'description',
        'type',
        'background_name',
        'background_extension',
        'font',
        'font_size',
        'font_color',
        'current_object_id',
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
    public function getCreatedByNameAttribute()
    {
        return isset($this->created_by) ? User::findOrFail($this->created_by)->full_name : __('common.unspecified');
    }
    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id', 'id');
    }
    public function timer()
    {
        return $this->hasOne(Timer::class, 'screen_id', 'id');
    }
    public function getCurrentObjectNameAttribute()
    {
        if ($this->current_object_id){
            if ($this->type == 'chair' || $this->type == 'speaker'){
                return Participant::findOrFail($this->current_object_id)->full_name;
            } elseif ($this->type == 'keypad') {
                return Keypad::findOrFail($this->current_object_id)->keypad;
            } elseif ($this->type == 'debate') {
                return Debate::findOrFail($this->current_object_id)->title;
            }
        } else {
            return null;
        }
    }
}
