<?php

namespace App\Models\Meeting\Document;

use App\Models\Meeting\Hall\Program\Session\Session;
//use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;
    protected $table = 'meeting_documents';
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
    public function getCreatedByNameAttribute()
    {
        return isset($this->created_by) ? User::findOrFail($this->created_by)->full_name : __('common.unspecified');
    }
    public function sessions()
    {
        return $this->hasMany(Session::class, 'document_id', 'id');
    }
}
