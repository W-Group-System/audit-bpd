<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorrectionImmediateAction extends Model
{
    public function corrective_action_request()
    {
        return $this->belongsTo(CorrectiveActionRequest::class);
    }
}
