<?php

namespace App\Domain\Customer\Models;

use App\Domain\Meeting\Models\Meeting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return url('storage/' . $this->logo);
        }
        return asset('images/default-logo.png');
    }
}
