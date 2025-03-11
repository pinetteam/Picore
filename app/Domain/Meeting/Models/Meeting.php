<?php

namespace App\Domain\Meeting\Models;

use App\Domain\Customer\Models\Customer;
use App\Domain\Meeting\Enums\MeetingStatusEnum;
use App\Domain\Meeting\Enums\MeetingTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meeting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'banner_name',
        'banner_extension',
        'banner_size',
        'code',
        'title',
        'type',
        'start_at',
        'finish_at',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'start_at' => 'date',
        'finish_at' => 'date',
        'status' => 'boolean',
        'type' => MeetingTypeEnum::class,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function halls(): HasMany
    {
        return $this->hasMany(MeetingHall::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(MeetingDocument::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(MeetingParticipant::class);
    }

// app/Domain/Meeting/Models/Meeting.php dosyasında

    public function getBannerUrlAttribute(): string
    {
        // Banner alanı dizi ise ve içinde dosya varsa
        if (is_array($this->banner) && !empty($this->banner)) {
            $bannerFile = is_array($this->banner) ? reset($this->banner) : $this->banner;
            return Storage::disk('public')->url($bannerFile);
        }

        // Banner bir dosya adı ise
        if (is_string($this->banner) && !empty($this->banner)) {
            return Storage::disk('public')->url($this->banner);
        }

        // Varsayılan görsel - çevrimiçi bir placeholder
        return 'https://placehold.co/1200x675/CCCCCC/808080.png?text=No+Image';
    }
    public function getStatusLabelAttribute(): string
    {
        return $this->status
            ? MeetingStatusEnum::ACTIVE->label()
            : MeetingStatusEnum::INACTIVE->label();
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status
            ? MeetingStatusEnum::ACTIVE->color()
            : MeetingStatusEnum::INACTIVE->color();
    }

    public function getDateRangeAttribute(): string
    {
        return $this->start_at->format('d.m.Y') . ' - ' . $this->finish_at->format('d.m.Y');
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type ? $this->type->label() : 'Belirsiz';
    }
}
