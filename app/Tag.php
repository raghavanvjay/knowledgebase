<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function entries()
    {
        return $this->belongsToMany('App\Entry','entries_tags');
    }
}
