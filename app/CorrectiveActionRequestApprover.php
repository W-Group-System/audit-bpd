<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CorrectiveActionRequestApprover extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function correctiveActionRequest()
    {
        return $this->belongsTo(CorrectiveActionRequest::class);
    }
}
