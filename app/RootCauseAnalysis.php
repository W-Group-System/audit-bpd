<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RootCauseAnalysis extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'root_cause_analysis';
}
