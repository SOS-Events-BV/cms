<?php

namespace SOSEventsBV\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use SOSEventsBV\Cms\Traits\HasContentBlocks;
use SOSEventsBV\Cms\Traits\HasSeo;

class Page extends Model
{
    use HasSeo, HasContentBlocks;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'content' => 'array',
    ];
}
