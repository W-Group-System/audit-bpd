<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OfiRemarksHistory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    public function correctiveActionRequest()
    {
        return $this->belongsTo(OfiImmediateAction::class, 'immediate_action_id');
    }
    
}
