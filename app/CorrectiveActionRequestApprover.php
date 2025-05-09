<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorrectiveActionRequestApprover extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function correctiveActionRequest()
    {
        return $this->belongsTo(CorrectiveActionRequest::class);
    }
}
