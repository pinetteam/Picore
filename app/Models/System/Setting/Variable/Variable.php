<?php

namespace App\Models\System\Setting\Variable;

use App\Models\Customer\Setting\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variable extends Model
{
    use SoftDeletes;
    protected $table = 'system_setting_variables';
    protected $fillable = [
        'group',
        'sort_order',
        'title',
        'variable',
        'type',
        'type_variables',
        'status',
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
        'type_variables' => 'array',
    ];
    public function settings()
    {
        return $this->hasMany(Setting::class, 'variable_id', 'id');
    }
}
