<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function dept_head()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
