<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfiImmediateAction extends Model
{
    public function ofi()
    {
        return $this->belongsTo(Ofi::class);
    }
}
