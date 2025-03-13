<?php

namespace App\Models\System\Country;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Country extends Model
{
    use  SoftDeletes;
    protected $table = 'system_countries';
    protected $fillable = [
        'name',
        'code',
        'short_name_2d',
        'short_name_3d',
        'phone_code',
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
    public function getNameAndCodeAttribute()
    {
        return Str::of($this->name . " (+" . $this->phone_code . ")")->trim();
    }
}
