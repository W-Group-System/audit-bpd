<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CorrectiveActionRequestVerifier extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    public function correctiveActionRequest()
    {
        return $this->belongsTo(CorrectiveActionRequest::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
