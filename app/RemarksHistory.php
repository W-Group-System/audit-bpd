<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RemarksHistory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    public function correctiveActionRequest()
    {
        return $this->belongsTo(CorrectiveActionRequest::class);
    }
    public function correctiveAction()
    {
        return $this->belongsTo(CorrectiveAction::class);
    }
}
