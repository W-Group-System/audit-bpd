<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorrectiveActionRequestVerifier extends Model
{
    public function correctiveActionRequest()
    {
        return $this->belongsTo(CorrectiveActionRequest::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
