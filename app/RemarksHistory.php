<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RemarksHistory extends Model
{
    public function correctiveActionRequest()
    {
        return $this->belongsTo(CorrectiveActionRequest::class);
    }
    public function correctiveAction()
    {
        return $this->belongsTo(CorrectiveAction::class);
    }
}
