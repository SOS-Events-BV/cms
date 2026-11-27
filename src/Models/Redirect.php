<?php

namespace SOSEventsBV\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Redirect extends Model
{
    protected $fillable = [
        'language',
        'from',
        'to',
        'status_code',
    ];
}
