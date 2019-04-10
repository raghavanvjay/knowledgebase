<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function entries()
    {
        return $this->hasMany('App\Entry');
    }
}
