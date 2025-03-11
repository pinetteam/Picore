<?php

namespace App\Domain\Meeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeetingDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'meeting_id',
        'file_name',
        'file_extension',
        'file_size',
        'title',
        'sharing_via_email',
        'allowed_to_review',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'sharing_via_email' => 'boolean',
        'allowed_to_review' => 'boolean',
        'status' => 'boolean',
    ];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    public function mails(): HasMany
    {
        return $this->hasMany(MeetingDocumentMail::class, 'document_id');
    }

    public function getFileUrlAttribute(): string
    {
        if ($this->file_name) {
            return asset('storage/documents/' . $this->meeting_id . '/' . $this->file_name);
        }

        return '';
    }
}
