<?php

namespace SOSEventsBV\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'exchange_rate',
    ];
}
