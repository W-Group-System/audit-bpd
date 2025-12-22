<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ofi extends Model
{
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function issuedBy()
    {
        return $this->belongsTo(User::class,'issued_by');
    }
    public function issuedTo()
    {
        return $this->belongsTo(User::class,'issued_to');
    }
    public function verifiers()
    {
        return $this->hasMany(OfiVerifier::class);
    }
    public function attachments()
    {
        return $this->hasMany(OfiAttachment::class);
    }
}
