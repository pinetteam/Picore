<?php

namespace App\Domain\Meeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeetingParticipant extends Model
{
    use HasFactory, SoftDeletes;

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
        'requested_all_documents',
        'enrolled',
        'enrolled_at',
        'gdpr_consent',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'requested_all_documents' => 'boolean',
        'enrolled' => 'boolean',
        'enrolled_at' => 'datetime',
        'gdpr_consent' => 'boolean',
        'status' => 'boolean',
        'last_login_datetime' => 'datetime',
        'last_activity' => 'datetime',
    ];

    protected $hidden = [
        'password',
    ];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    public function dailyAccesses(): HasMany
    {
        return $this->hasMany(MeetingParticipantDailyAccess::class, 'participant_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(MeetingParticipantLog::class, 'participant_id');
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
