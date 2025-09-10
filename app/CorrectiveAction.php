<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CorrectiveAction extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    public function remarks_history()
    {
        return $this->hasMany(RemarksHistory::class);
    }
    public function corrective_action_request()
    {
        return $this->belongsTo(CorrectiveActionRequest::class);
    }
}
