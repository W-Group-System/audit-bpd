<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfiVerifier extends Model
{
    public function ofi()
    {
        return $this->belongsTo(Ofi::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
