<?php

namespace App;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model;

class Location extends Model
{
    protected $guarded = [];

    /**
     * @param $query
     * @param $from
     * @param $to
     * @return mixed
     */
    public function scopeCreatedAtBetween($query, $from, $to)
    {
        return $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)->endOfDay()]);
    }
}
