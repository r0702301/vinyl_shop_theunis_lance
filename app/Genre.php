<?php

namespace App;

use Faker\Guesser\Name;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public function records()
    {
        return $this->hasMany('App\Record')->orderBy('artist', 'asc');   // a genre has many records
    }
}
