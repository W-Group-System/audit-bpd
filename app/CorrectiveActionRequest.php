<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorrectiveActionRequest extends Model
{
    public function auditor()
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }
    public function auditee()
    {
        return $this->belongsTo(User::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function correctiveAction()
    {
        return $this->hasMany(CorrectiveAction::class);
    }
    public function approver()
    {
        return $this->hasMany(CorrectiveActionRequestApprover::class);
    }
    public function verify()
    {
        return $this->hasMany(CorrectiveActionRequestVerifier::class);
    }
    public function remarksHistory()
    {
        return $this->hasMany(RemarksHistory::class);
    }
}
