<?php

namespace App\Domain\Meeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeetingHall extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'meeting_id',
        'code',
        'title',
        'show_on_session',
        'show_on_view_program',
        'show_on_ask_question',
        'show_on_send_mail',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'show_on_session' => 'boolean',
        'show_on_view_program' => 'boolean',
        'show_on_ask_question' => 'boolean',
        'show_on_send_mail' => 'boolean',
        'status' => 'boolean',
    ];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(MeetingHallProgram::class, 'hall_id');
    }

    public function screens(): HasMany
    {
        return $this->hasMany(MeetingHallScreen::class, 'hall_id');
    }
}
