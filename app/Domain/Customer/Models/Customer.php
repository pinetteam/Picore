<?php

namespace App\Domain\Customer\Models;

use App\Domain\Meeting\Models\Meeting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'icon',
        'logo',
        'credit',
        'language',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return url('storage/' . $this->logo);
        }
        return asset('images/default-logo.png');
    }
}
