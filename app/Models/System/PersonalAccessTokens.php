<?php

namespace App\Models\System;

use App\Models\Meeting\Participant\Participant;
use Illuminate\Database\Eloquent\Model;

class PersonalAccessTokens extends Model
{
    protected $table = 'personal_access_tokens';

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'tokenable_id', 'id');
    }

}
