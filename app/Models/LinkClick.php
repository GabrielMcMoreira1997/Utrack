<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkClick extends Model
{
    protected $fillable = [
        'link_id',
        'country',
        'region',
        'city',
        'latitude',
        'longitude',
        'device',
        'os',
        'os_version',
        'browser',
        'browser_version',
        'language',
        'referrer',
        'clicked_at',
    ];


    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}