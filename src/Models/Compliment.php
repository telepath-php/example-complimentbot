<?php

namespace Telepath\ComplimentBot\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Compliment extends Model
{

    protected $guarded = [];

    public function scopeSearch(Builder $query, string $term)
    {
        return $query->whereFullText('compliment', $term)
            ->orderByDesc('usage');
    }

}