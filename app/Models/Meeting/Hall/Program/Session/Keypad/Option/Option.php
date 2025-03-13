<?php

namespace App\Models\Meeting\Hall\Program\Session\Keypad\Option;

use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use App\Models\Meeting\Hall\Program\Session\Keypad\Vote\Vote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Option extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_hall_program_session_keypad_options';
    protected $fillable = [
        'sort_order',
        'keypad_id',
        'option',
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
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function keypad()
    {
        return $this->belongsTo(Keypad::class, 'keypad_id', 'id');
    }
    public function votes(){
        return $this->hasMany(Vote::class, 'option_id', 'id');
    }
}
